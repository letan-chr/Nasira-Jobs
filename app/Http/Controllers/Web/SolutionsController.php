<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Support\SitemapXml;
use App\Support\SolutionsCatalog;
use App\Support\SolutionsSeo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SolutionsController extends Controller
{
    public function index(): View
    {
        $groups = SolutionsCatalog::groups();
        $total = SolutionsCatalog::count();
        $seo = SolutionsSeo::forIndex($total);

        return view('front_web.solutions.index', compact('groups', 'total', 'seo'));
    }

    public function show(string $slug): View|RedirectResponse
    {
        $tool = SolutionsCatalog::find($slug);
        if (! $tool) {
            abort(404);
        }

        if (! empty($tool['route'])) {
            return redirect()->route($tool['route']);
        }

        $groups = SolutionsCatalog::groups();
        $related = collect($groups[$tool['group']]['items'] ?? [])
            ->reject(fn ($item) => ($item['slug'] ?? '') === $slug)
            ->take(6)
            ->values()
            ->all();
        $seo = SolutionsSeo::forTool($tool);

        return view('front_web.solutions.show', compact('tool', 'groups', 'related', 'seo'));
    }

    public function sitemap(): Response
    {
        return response(SitemapXml::urlset(SolutionsSeo::sitemapEntries()), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
