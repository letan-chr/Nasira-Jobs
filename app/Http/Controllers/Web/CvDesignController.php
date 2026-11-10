<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\CandidateCvDesign;
use App\Models\CvTemplate;
use App\Support\CvCanvasTemplates;
use App\Support\CvDesignSeo;
use App\Support\SitemapXml;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CvDesignController extends AppBaseController
{
    public function index(Request $request): View
    {
        $category = $request->get('category');
        $templates = CvTemplate::active()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->paginate(24)
            ->withQueryString();

        // Backfill only missing canvas HTML (avoid rebuilding 100+ on every visit)
        foreach ($templates as $template) {
            if (blank($template->html)) {
                $canvas = CvCanvasTemplates::forSlug($template->slug);
                $template->forceFill([
                    'html' => $canvas['html'],
                    'css' => $canvas['css'],
                ])->save();
            }
        }

        $categories = CvTemplate::active()->select('category')->distinct()->orderBy('category')->pluck('category');
        $templateTotal = CvTemplate::active()->count();

        $savedDesigns = Auth::check()
            ? CandidateCvDesign::where('user_id', Auth::id())->with('template')->latest()->get()
            : collect();

        $seo = CvDesignSeo::forIndex($templateTotal, $category);

        return view('front_web.cv_design.index', compact(
            'templates',
            'categories',
            'category',
            'savedDesigns',
            'templateTotal',
            'seo'
        ));
    }

    public function editor(Request $request, ?string $slug = null): View
    {
        $templateOptions = CvTemplate::active()->orderBy('sort_order')->get(['id', 'slug', 'name', 'category']);
        $template = $slug
            ? CvTemplate::active()->where('slug', $slug)->firstOrFail()
            : (CvTemplate::active()->first() ?? abort(404, 'No CV templates available.'));

        $canvas = CvCanvasTemplates::forSlug($template->slug);
        if (blank($template->html)) {
            $template->forceFill([
                'html' => $canvas['html'],
                'css' => $canvas['css'],
            ])->save();
        }

        // Side panel: same category first (keeps editor light with 100+ templates)
        $templates = CvTemplate::active()
            ->where('category', $template->category)
            ->orderBy('sort_order')
            ->limit(36)
            ->get();

        $design = null;
        $designId = $request->integer('design');
        if ($designId && Auth::check()) {
            $design = CandidateCvDesign::where('user_id', Auth::id())
                ->with('template')
                ->find($designId);
            if ($design?->template) {
                $template = $design->template;
            }
        }

        $html = $design?->html ?: $canvas['html'];
        $css = $design?->css ?: $canvas['css'];
        $projectJson = $design?->project_json;

        // Guests: restore draft from session when not opening a saved design
        if (! $design && ! Auth::check()) {
            $draft = session('cv_guest_draft');
            if (is_array($draft) && (int) ($draft['cv_template_id'] ?? 0) === (int) $template->id) {
                $html = $draft['html'] ?? $html;
                $css = $draft['css'] ?? $css;
                $projectJson = $draft['project_json'] ?? $projectJson;
            }
        }

        $savedDesigns = Auth::check()
            ? CandidateCvDesign::where('user_id', Auth::id())->with('template')->latest()->get()
            : collect();

        $guestImages = session('cv_guest_images', []);
        $seo = CvDesignSeo::forTemplate($template, (bool) $design);

        return view('front_web.cv_design.canvas', compact(
            'templates',
            'templateOptions',
            'template',
            'design',
            'html',
            'css',
            'projectJson',
            'savedDesigns',
            'guestImages',
            'seo'
        ));
    }

    public function sitemap(): Response
    {
        return response(SitemapXml::urlset(CvDesignSeo::sitemapEntries()), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'cv_template_id' => 'required|exists:cv_templates,id',
            'title' => 'required|string|max:150',
            'html' => 'required|string',
            'css' => 'nullable|string',
            'project_json' => 'nullable',
            'design_id' => 'nullable|integer',
            'is_default' => 'nullable|boolean',
        ]);

        if (! Auth::check() || ! Auth::user()->hasRole('Candidate')) {
            // Keep a guest draft in session so they don't lose work before login
            $this->storeGuestDraft($data);

            return $this->sendError('Login as a candidate to permanently save your CV. Your draft is kept in this session.', 401);
        }

        $project = $this->normalizeProject($data['project_json'] ?? null);

        $payload = [
            'user_id' => Auth::id(),
            'cv_template_id' => $data['cv_template_id'],
            'title' => $data['title'],
            'html' => $data['html'],
            'css' => $data['css'] ?? '',
            'project_json' => $project,
            'content' => [],
            'settings' => [],
            'is_default' => (bool) ($data['is_default'] ?? true),
        ];

        if (! empty($data['design_id'])) {
            $design = CandidateCvDesign::where('user_id', Auth::id())->findOrFail($data['design_id']);
            $design->update($payload);
        } else {
            $design = CandidateCvDesign::create($payload);
        }

        if ($design->is_default) {
            CandidateCvDesign::where('user_id', Auth::id())
                ->where('id', '!=', $design->id)
                ->update(['is_default' => false]);
        }

        // Clear guest draft after permanent save
        session()->forget('cv_guest_draft');

        $tplSlug = optional($design->template)->slug
            ?: optional(CvTemplate::find($design->cv_template_id))->slug
            ?: 'nasira-modern';

        return $this->sendResponse([
            'id' => $design->id,
            'title' => $design->title,
            'url' => route('front.cv.editor', $tplSlug).'?design='.$design->id,
        ], 'CV design saved successfully.');
    }

    public function saveGuestDraft(Request $request): JsonResponse
    {
        // Candidates should use permanent Save; guests / other roles keep session drafts
        if (Auth::check() && Auth::user()->hasRole('Candidate')) {
            return $this->sendError('Use Save resume to store your CV permanently.', 400);
        }

        $data = $request->validate([
            'cv_template_id' => 'required|exists:cv_templates,id',
            'title' => 'nullable|string|max:150',
            'html' => 'required|string',
            'css' => 'nullable|string',
            'project_json' => 'nullable',
        ]);

        $this->storeGuestDraft($data);

        return $this->sendResponse(['storage' => 'session'], 'Draft saved in session.');
    }

    public function destroy(CandidateCvDesign $design): JsonResponse
    {
        if (! Auth::check() || $design->user_id !== Auth::id()) {
            return $this->sendError('Unauthorized', 403);
        }

        $design->delete();

        return $this->sendSuccess('CV design deleted.');
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,webp,gif|max:5120',
        ]);

        $file = $request->file('file');

        // Guests: keep image in session (data URL) — no permanent disk storage
        if (! Auth::check()) {
            $mime = $file->getMimeType() ?: 'image/jpeg';
            $binary = file_get_contents($file->getRealPath());
            $src = 'data:'.$mime.';base64,'.base64_encode($binary);

            $images = collect(session('cv_guest_images', []))
                ->push([
                    'src' => $src,
                    'name' => $file->getClientOriginalName(),
                    'uploaded_at' => now()->toIso8601String(),
                ])
                ->take(-3)
                ->values()
                ->all();

            session(['cv_guest_images' => $images]);

            return $this->sendResponse([
                'src' => $src,
                'url' => $src,
                'name' => $file->getClientOriginalName(),
                'storage' => 'session',
            ], 'Image stored in session.');
        }

        $folder = 'cv-uploads/'.Auth::id();
        $path = $file->store($folder, 'public');
        $url = Storage::disk('public')->url($path);

        return $this->sendResponse([
            'src' => $url,
            'url' => $url,
            'name' => basename($path),
            'storage' => 'disk',
        ], 'Image uploaded.');
    }

    private function storeGuestDraft(array $data): void
    {
        session([
            'cv_guest_draft' => [
                'cv_template_id' => (int) $data['cv_template_id'],
                'title' => $data['title'] ?? 'My Resume',
                'html' => $data['html'],
                'css' => $data['css'] ?? '',
                'project_json' => $this->normalizeProject($data['project_json'] ?? null),
                'updated_at' => now()->toIso8601String(),
            ],
        ]);
    }

    private function normalizeProject(mixed $project): mixed
    {
        if (is_string($project)) {
            $decoded = json_decode($project, true);

            return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }

        return $project;
    }
}
