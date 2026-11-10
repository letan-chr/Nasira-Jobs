<?php

namespace App\Support;

/**
 * Public tools — FreeConvert-style Convert + Compress catalog,
 * plus Nasira career helpers.
 */
class SolutionsCatalog
{
    /**
     * @return array<string, array{title:string,blurb:string,section?:string,items:array<int, array<string, mixed>>}>
     */
    public static function groups(): array
    {
        return [
            'convert-video-audio' => [
                'title' => 'Video & Audio',
                'blurb' => 'Convert video and audio formats in your browser',
                'section' => 'Convert',
                'items' => [
                    self::tool('video-converter', 'Video Converter', 'Convert videos between common formats (MP4, WEBM, MOV…).', 'fa-video', 'ffmpeg', ['mp4', 'webm', 'mov', 'mkv', 'avi'], null, 'Best-effort: loads FFmpeg.wasm (~25MB) on first use.'),
                    self::tool('audio-converter', 'Audio Converter', 'Convert audio between MP3, WAV, OGG, AAC and more.', 'fa-music', 'ffmpeg', ['mp3', 'wav', 'ogg', 'aac', 'm4a'], null, 'Best-effort: FFmpeg.wasm.'),
                    self::tool('mp3-converter', 'MP3 Converter', 'Convert audio or video soundtracks to MP3.', 'fa-file-audio', 'ffmpeg', ['mp3'], null, 'Best-effort: FFmpeg.wasm.'),
                    self::tool('mp4-to-mp3', 'MP4 to MP3', 'Extract audio from MP4 as an MP3 file.', 'fa-file-audio', 'ffmpeg', ['mp3'], 'video/*', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('video-to-mp3', 'Video to MP3', 'Turn any video into an MP3 audio track.', 'fa-headphones', 'ffmpeg', ['mp3'], 'video/*', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('mp4-converter', 'MP4 Converter', 'Convert video files to MP4.', 'fa-film', 'ffmpeg', ['mp4'], 'video/*', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('mov-to-mp4', 'MOV to MP4', 'Convert Apple MOV videos to MP4.', 'fa-exchange-alt', 'ffmpeg', ['mp4'], 'video/*,.mov', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('mp3-to-ogg', 'MP3 to OGG', 'Convert MP3 audio to OGG.', 'fa-file-audio', 'ffmpeg', ['ogg'], 'audio/mpeg,.mp3', 'Best-effort: FFmpeg.wasm.'),
                ],
            ],
            'convert-image' => [
                'title' => 'Image',
                'blurb' => 'Convert images online — FreeConvert style',
                'section' => 'Convert',
                'items' => [
                    self::tool('image-converter', 'Image Converter', 'Convert between JPG, PNG, WEBP, GIF and more.', 'fa-images', 'image', ['jpg', 'png', 'webp', 'gif']),
                    self::tool('webp-to-png', 'WEBP to PNG', 'Convert WEBP images to PNG.', 'fa-file-image', 'image', ['png'], 'image/webp,.webp'),
                    self::tool('jfif-to-png', 'JFIF to PNG', 'Convert JFIF/JPEG images to PNG.', 'fa-file-image', 'image', ['png'], 'image/jpeg,.jfif,.jpg,.jpeg'),
                    self::tool('png-to-svg', 'PNG to SVG', 'Wrap PNG as an SVG (embedded raster — not vectorized paths).', 'fa-vector-square', 'image', ['svg'], 'image/png,.png', 'Best-effort: embeds the PNG inside SVG; does not trace vectors.'),
                    self::tool('heic-to-jpg', 'HEIC to JPG', 'Convert iPhone HEIC photos to JPG.', 'fa-mobile-alt', 'heic', ['jpg'], 'image/heic,image/heif,.heic,.heif', 'Best-effort: depends on browser HEIC support / heic2any.'),
                    self::tool('heic-to-png', 'HEIC to PNG', 'Convert HEIC photos to PNG.', 'fa-mobile-alt', 'heic', ['png'], 'image/heic,image/heif,.heic,.heif', 'Best-effort: depends on browser HEIC support / heic2any.'),
                    self::tool('webp-to-jpg', 'WEBP to JPG', 'Convert WEBP images to JPG.', 'fa-file-image', 'image', ['jpg'], 'image/webp,.webp'),
                    self::tool('svg-converter', 'SVG Converter', 'Rasterize SVG to PNG, JPG, or WEBP.', 'fa-bezier-curve', 'image', ['png', 'jpg', 'webp'], 'image/svg+xml,.svg'),
                    self::tool('png-to-jpg', 'PNG to JPG', 'Convert PNG to JPG with fill color & quality.', 'fa-file-image', 'special', ['jpg'], 'image/png,.png'),
                    self::tool('jpg-to-png', 'JPG to PNG', 'Convert JPG images to PNG.', 'fa-file-image', 'image', ['png'], 'image/jpeg,.jpg,.jpeg'),
                ],
            ],
            'convert-pdf' => [
                'title' => 'PDF & Documents',
                'blurb' => 'Convert PDFs and office documents',
                'section' => 'Convert',
                'items' => [
                    self::tool('pdf-converter', 'PDF Converter', 'Convert images or text into PDF, or export PDF pages.', 'fa-file-pdf', 'pdf', ['pdf', 'jpg', 'png']),
                    self::tool('document-converter', 'Document Converter', 'Convert Word (.docx) to PDF or extract text.', 'fa-file-alt', 'doc', ['pdf', 'txt'], '.docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
                    self::tool('ebook-converter', 'Ebook Converter', 'Build a simple EPUB from text or convert EPUB text out.', 'fa-book', 'ebook', ['epub', 'txt'], null, 'Best-effort: text-focused EPUB; complex layouts may be lost.'),
                    self::tool('pdf-to-word', 'PDF to Word', 'Convert selectable PDF text into a .docx (scanned PDFs need OCR elsewhere).', 'fa-file-word', 'special', [], null, 'Text-only extraction. Scanned/image PDFs will be mostly empty.'),
                    self::tool('pdf-to-jpg', 'PDF to JPG', 'Export PDF pages as JPG images (ZIP).', 'fa-file-image', 'pdf', ['jpg'], 'application/pdf,.pdf'),
                    self::tool('pdf-to-epub', 'PDF to EPUB', 'Extract PDF text into a basic EPUB ebook.', 'fa-book-open', 'ebook', ['epub'], 'application/pdf,.pdf', 'Best-effort: text extraction only; scanned PDFs unsupported.'),
                    self::tool('epub-to-pdf', 'EPUB to PDF', 'Convert EPUB text content into a PDF.', 'fa-file-pdf', 'ebook', ['pdf'], 'application/epub+zip,.epub', 'Best-effort: text content only.'),
                    self::tool('heic-to-pdf', 'HEIC to PDF', 'Convert HEIC photos into a PDF.', 'fa-file-pdf', 'heic', ['pdf'], 'image/heic,image/heif,.heic,.heif', 'Best-effort: depends on browser HEIC support.'),
                    self::tool('word-to-pdf', 'Word to PDF', 'Upload a .docx and download a PDF.', 'fa-file-pdf', 'special', [], '.docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'Formatting is approximate (browser HTML → PDF).'),
                    self::tool('jpg-to-pdf', 'JPG to PDF', 'Combine JPG images into one PDF.', 'fa-file-pdf', 'pdf', ['pdf'], 'image/jpeg,.jpg,.jpeg'),
                    self::tool('txt-to-pdf', 'Text to PDF', 'Turn plain text into a downloadable PDF.', 'fa-file-alt', 'special'),
                    self::tool('markdown-to-pdf', 'Markdown to PDF', 'Convert markdown notes to PDF.', 'fa-code', 'special'),
                ],
            ],
            'convert-gif' => [
                'title' => 'GIF',
                'blurb' => 'Create and convert GIFs',
                'section' => 'Convert',
                'items' => [
                    self::tool('video-to-gif', 'Video to GIF', 'Convert video clips to animated GIF.', 'fa-film', 'ffmpeg', ['gif'], 'video/*', 'Best-effort: loads FFmpeg.wasm (~25MB) on first use.'),
                    self::tool('mp4-to-gif', 'MP4 to GIF', 'Convert MP4 video to GIF.', 'fa-file-video', 'ffmpeg', ['gif'], 'video/mp4,.mp4', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('webm-to-gif', 'WEBM to GIF', 'Convert WEBM video to GIF.', 'fa-file-video', 'ffmpeg', ['gif'], 'video/webm,.webm', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('apng-to-gif', 'APNG to GIF', 'Convert animated PNG to GIF.', 'fa-image', 'ffmpeg', ['gif'], 'image/png,.png,.apng', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('gif-to-mp4', 'GIF to MP4', 'Convert GIF animations to MP4.', 'fa-file-video', 'ffmpeg', ['mp4'], 'image/gif,.gif', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('gif-to-apng', 'GIF to APNG', 'Convert GIF to animated PNG.', 'fa-image', 'ffmpeg', ['png'], 'image/gif,.gif', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('image-to-gif', 'Image to GIF', 'Combine images into an animated GIF.', 'fa-images', 'ffmpeg', ['gif'], 'image/*', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('mov-to-gif', 'MOV to GIF', 'Convert MOV video to GIF.', 'fa-film', 'ffmpeg', ['gif'], 'video/*,.mov', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('avi-to-gif', 'AVI to GIF', 'Convert AVI video to GIF.', 'fa-film', 'ffmpeg', ['gif'], 'video/*,.avi', 'Best-effort: FFmpeg.wasm.'),
                ],
            ],
            'convert-others' => [
                'title' => 'Others',
                'blurb' => 'Archives and time helpers',
                'section' => 'Convert',
                'items' => [
                    self::tool('timezone-converter', 'Timezone Helper', 'Compare interview times across zones.', 'fa-clock', 'special'),
                    self::tool('archive-converter', 'Archive Converter', 'Zip / unzip files in your browser.', 'fa-file-archive', 'archive', ['zip']),
                ],
            ],
            'tools' => [
                'title' => 'Tools',
                'blurb' => 'Everyday creative and utility tools',
                'section' => 'Tools',
                'items' => [
                    self::tool('background-remover', 'Background Remover', 'Remove image background for a clean profile photo.', 'fa-eraser', 'special', [], null, 'Uses on-device AI (first run downloads ~80MB). Best on clear subjects; falls back to studio edge removal if AI cannot run.'),
                    self::tool('image-resizer', 'Image Resizer', 'Resize images to exact pixel dimensions.', 'fa-expand', 'special'),
                    self::tool('image-cropper', 'Image Cropper', 'Crop photos for avatar or cover sizes.', 'fa-crop', 'special'),
                    self::tool('passport-photo', 'Passport Photo Maker', 'Create a square CV/passport-style photo.', 'fa-id-badge', 'special'),
                    self::tool('color-picker', 'Color Picker', 'W3Schools-style picker plus upload-an-image eyedropper for HEX/RGB/HSL.', 'fa-eye-dropper', 'special'),
                    self::tool('unit-converter', 'Unit Converter', 'Convert 500+ units: length, mass, energy, data, pressure, cooking, and more.', 'fa-ruler-combined', 'unit'),
                    self::tool('qr-code-generator', 'QR Code Generator', 'Create a QR code for your portfolio link.', 'fa-qrcode', 'special'),
                    self::tool('word-counter', 'Word Counter', 'Count words, characters, and reading time.', 'fa-spell-check', 'special'),
                    self::tool('case-converter', 'Case Converter', 'UPPER, lower, Title Case, snake_case.', 'fa-font', 'special'),
                    self::tool('pdf-merger', 'PDF Merger', 'Merge multiple PDF files into one.', 'fa-object-group', 'special'),
                    self::tool('pdf-splitter', 'PDF Splitter', 'Split every page into separate PDFs (ZIP).', 'fa-cut', 'special'),
                    self::tool('base64-image', 'Base64 Image Tool', 'Encode/decode images as Base64.', 'fa-file-code', 'special'),
                ],
            ],
            'compress-video-audio' => [
                'title' => 'Video & Audio',
                'blurb' => 'Shrink media files for sharing',
                'section' => 'Compress',
                'items' => [
                    self::tool('video-compressor', 'Video Compressor', 'Compress videos with quality control.', 'fa-compress', 'ffmpeg', ['mp4'], 'video/*', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('mp3-compressor', 'MP3 Compressor', 'Reduce MP3 bitrate / file size.', 'fa-compress', 'ffmpeg', ['mp3'], 'audio/mpeg,.mp3', 'Best-effort: FFmpeg.wasm.'),
                    self::tool('wav-compressor', 'WAV Compressor', 'Convert/compress WAV to a smaller MP3.', 'fa-compress', 'ffmpeg', ['mp3'], 'audio/wav,.wav', 'Best-effort: FFmpeg.wasm.'),
                ],
            ],
            'compress-image' => [
                'title' => 'Image',
                'blurb' => 'Compress images for faster uploads',
                'section' => 'Compress',
                'items' => [
                    self::tool('image-compressor', 'Image Compressor', 'Reduce image file size with quality control.', 'fa-compress', 'image', ['jpg', 'png', 'webp'], 'image/*'),
                    self::tool('jpeg-compressor', 'JPEG Compressor', 'Compress JPG/JPEG photos.', 'fa-compress', 'image', ['jpg'], 'image/jpeg,.jpg,.jpeg'),
                    self::tool('png-compressor', 'PNG Compressor', 'Shrink PNG size (re-encode / optional JPG).', 'fa-compress', 'image', ['png', 'jpg'], 'image/png,.png'),
                    self::tool('gif-compressor', 'GIF Compressor', 'Compress animated GIFs with ffmpeg.', 'fa-compress', 'ffmpeg', ['gif'], 'image/gif,.gif', 'Best-effort: FFmpeg.wasm.'),
                ],
            ],
            'compress-pdf' => [
                'title' => 'PDF & Documents',
                'blurb' => 'Make PDFs smaller for job boards',
                'section' => 'Compress',
                'items' => [
                    self::tool('pdf-compressor', 'PDF Compressor', 'Shrink PDF size for uploads (re-save / strip extras).', 'fa-file-archive', 'special', [], null, 'Best-effort: may not shrink heavily image-based PDFs.'),
                ],
            ],
            'career' => [
                'title' => 'Career Tools',
                'blurb' => 'Tools that help you get hired faster',
                'section' => 'Career',
                'items' => [
                    ['slug' => 'cv-designer', 'name' => 'CV Designer', 'desc' => 'Open the Nasira Canva-style resume studio.', 'icon' => 'fa-id-card', 'route' => 'front.cv.design', 'engine' => 'route'],
                    self::tool('cover-letter-helper', 'Cover Letter Helper', 'Generate a starter cover letter from prompts.', 'fa-envelope-open-text', 'special'),
                    self::tool('resume-checker', 'Resume Checklist', 'Interactive checklist before you apply.', 'fa-clipboard-check', 'special'),
                    self::tool('salary-calculator', 'Salary Calculator', 'Estimate monthly / annual take-home basics.', 'fa-calculator', 'special'),
                    self::tool('interview-prep', 'Interview Prep', 'Common interview questions by role type.', 'fa-comments', 'special'),
                    self::tool('job-description-keywords', 'JD Keyword Finder', 'Extract keywords from a job description.', 'fa-key', 'special'),
                ],
            ],
            'productivity' => [
                'title' => 'Productivity',
                'blurb' => 'Everyday helpers for applications & work',
                'section' => 'Career',
                'items' => [
                    self::tool('lorem-generator', 'Lorem Generator', 'Generate placeholder text for drafts.', 'fa-paragraph', 'special'),
                ],
            ],
        ];
    }

    /**
     * @param  array<int, string>  $outputs
     * @return array<string, mixed>
     */
    private static function tool(
        string $slug,
        string $name,
        string $desc,
        string $icon,
        string $engine,
        array $outputs = [],
        ?string $accept = null,
        ?string $note = null
    ): array {
        $item = [
            'slug' => $slug,
            'name' => $name,
            'desc' => $desc,
            'icon' => $icon,
            'engine' => $engine,
            'outputs' => $outputs,
            'accept' => $accept,
        ];

        if ($note) {
            $item['note'] = $note;
        }

        return $item;
    }

    public static function megaGroups(): array
    {
        $all = self::groups();
        $mega = [];

        $blurbs = [
            'Convert' => 'Video, image, PDF, GIF & more',
            'Compress' => 'Shrink files fast',
            'Tools' => 'Background remover, picker & utilities',
            'Career' => 'Get hired faster',
        ];

        foreach (['Convert', 'Compress', 'Tools', 'Career'] as $section) {
            $items = [];
            foreach ($all as $group) {
                if (($group['section'] ?? '') !== $section) {
                    continue;
                }
                $limit = $section === 'Tools' ? 8 : ($section === 'Career' ? 6 : 5);
                foreach (array_slice($group['items'], 0, $limit) as $item) {
                    $items[] = $item;
                }
            }
            $mega[strtolower($section)] = [
                'title' => $section === 'Tools' ? 'Tool' : $section,
                'blurb' => $blurbs[$section] ?? '',
                'items' => $items,
            ];
        }

        return $mega;
    }

    public static function allItems(): array
    {
        $items = [];
        foreach (self::groups() as $groupKey => $group) {
            foreach ($group['items'] as $item) {
                $item['group'] = $groupKey;
                $item['group_title'] = $group['title'];
                $item['section'] = $group['section'] ?? '';
                $items[$item['slug']] = $item;
            }
        }

        return $items;
    }

    public static function find(string $slug): ?array
    {
        // Legacy aliases after catalog dedupe.
        $aliases = [
            'docx-to-pdf' => 'word-to-pdf',
            'time-converter' => 'timezone-converter',
        ];
        $slug = $aliases[$slug] ?? $slug;

        return self::allItems()[$slug] ?? null;
    }

    public static function count(): int
    {
        return count(self::allItems());
    }
}
