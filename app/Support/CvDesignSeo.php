<?php

namespace App\Support;

/**
 * Advanced SEO for CV Design gallery + template editor pages.
 */
class CvDesignSeo
{
    /**
     * @return array<string, mixed>
     */
    public static function forIndex(int $total, ?string $category = null): array
    {
        $brand = self::brand();
        $catLabel = $category ? ucfirst($category) : null;

        if ($catLabel) {
            $title = "{$catLabel} CV Templates — Free Resume Designer | {$brand}";
            $description = self::clip(
                "Browse {$catLabel} CV templates in the {$brand} Canva-style resume studio. Customize A4 layouts, export PDF, and apply faster with {$total}+ professional designs.",
                158
            );
            $canonical = route('front.cv.design', ['category' => $category]);
        } else {
            $title = "Free Online CV Designer — {$total}+ Resume Templates | {$brand}";
            $description = self::clip(
                "Design a job-ready resume with {$brand}'s Canva-style CV studio. Choose from {$total}+ free A4 templates, drag-and-drop edit, and download PDF — no design skills needed.",
                158
            );
            $canonical = route('front.cv.design');
        }

        $keywords = array_values(array_unique(array_filter([
            'free cv designer',
            'online resume builder',
            'cv templates',
            'resume templates',
            'canva style cv',
            'pdf resume download',
            'ats resume template',
            'nasira jobs cv',
            $catLabel ? strtolower($catLabel).' cv template' : null,
            $catLabel ? strtolower($catLabel).' resume template' : null,
        ])));

        $ogImage = self::ogImage();
        $faqs = self::indexFaqs($total, $catLabel);
        $benefits = [
            "{$total}+ professional A4 CV templates",
            'Canva-style visual editor with drag & drop',
            'PDF export for job applications',
            'Modern, classic, sidebar, ATS, and creative layouts',
            'Free to start — built for Nasira Jobs candidates',
        ];

        return [
            'title' => $title,
            'meta_title' => $title,
            'description' => $description,
            'keywords' => implode(', ', $keywords),
            'canonical' => $canonical,
            'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $canonical,
            'og_image' => $ogImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $ogImage,
            'intro' => $catLabel
                ? "Explore {$catLabel} resume templates in the {$brand} CV Designer. Open any layout in the visual studio, customize every block, and export a polished PDF."
                : "Build a standout resume with the {$brand} CV Designer — a Canva-style studio with {$total}+ templates for modern, classic, sidebar, ATS, and creative careers.",
            'benefits' => $benefits,
            'faqs' => $faqs,
            'howto_steps' => self::howToSteps(),
            'json_ld' => self::indexJsonLd($title, $description, $canonical, $ogImage, $faqs, $total),
        ];
    }

    /**
     * @param  array<string, mixed>|\App\Models\CvTemplate  $template
     * @return array<string, mixed>
     */
    public static function forTemplate($template, bool $isPersonalDesign = false): array
    {
        $name = (string) data_get($template, 'name', 'CV Template');
        $slug = (string) data_get($template, 'slug', '');
        $category = (string) data_get($template, 'category', 'modern');
        $descriptionRaw = trim((string) data_get($template, 'description', ''));
        $brand = self::brand();
        $catLabel = ucfirst($category);

        $title = "{$name} CV Template — Free Online Resume Designer | {$brand}";
        $description = self::clip(
            ($descriptionRaw !== '' ? rtrim($descriptionRaw, '.').'. ' : '')
            ."Edit the {$name} {$catLabel} resume template online in {$brand}'s Canva-style CV designer. Customize colors, sections, and export PDF free.",
            158
        );

        $canonical = route('front.cv.editor', $slug);
        $keywords = array_values(array_unique([
            strtolower($name).' cv template',
            strtolower($name).' resume',
            strtolower($catLabel).' cv template',
            strtolower($catLabel).' resume template',
            'free online cv designer',
            'edit resume online',
            'download cv pdf',
            'nasira jobs resume',
            str_replace('-', ' ', $slug),
        ]));

        $ogImage = self::ogImage();
        $faqs = self::templateFaqs($name, $catLabel, $descriptionRaw);
        $steps = self::howToSteps($name);
        $robots = $isPersonalDesign
            ? 'noindex, nofollow'
            : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';

        return [
            'title' => $title,
            'meta_title' => $title,
            'description' => $description,
            'keywords' => implode(', ', $keywords),
            'canonical' => $canonical,
            'robots' => $robots,
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_url' => $canonical,
            'og_image' => $ogImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $ogImage,
            'intro' => "Use the {$name} template to design a {$catLabel} resume online. "
                .($descriptionRaw !== '' ? rtrim($descriptionRaw, '.').'. ' : '')
                ."Open it in the {$brand} visual CV studio, personalize every section, then download PDF for applications.",
            'benefits' => [
                "Free {$name} CV template",
                "{$catLabel} layout optimized for professional applications",
                'Drag-and-drop Canva-style editing',
                'A4 preview with PDF export',
                'Switch templates anytime without starting over',
            ],
            'faqs' => $faqs,
            'howto_steps' => $steps,
            'json_ld' => self::templateJsonLd($name, $slug, $catLabel, $title, $description, $canonical, $ogImage, $faqs, $steps),
        ];
    }

    /**
     * @return list<array{loc:string,lastmod:string,changefreq:string,priority:string}>
     */
    public static function sitemapEntries(): array
    {
        $now = now()->toAtomString();
        $entries = [[
            'loc' => route('front.cv.design'),
            'lastmod' => $now,
            'changefreq' => 'weekly',
            'priority' => '0.9',
        ]];

        $categories = [];
        foreach (CvTemplateCatalog::all() as $item) {
            $categories[$item['category']] = true;
            $entries[] = [
                'loc' => route('front.cv.editor', $item['slug']),
                'lastmod' => $now,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        foreach (array_keys($categories) as $category) {
            $entries[] = [
                'loc' => route('front.cv.design', ['category' => $category]),
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        return $entries;
    }

    private static function brand(): string
    {
        try {
            $name = function_exists('getAppName') ? (string) getAppName() : '';
        } catch (\Throwable) {
            $name = '';
        }

        return $name !== '' ? $name : 'Nasira Jobs';
    }

    private static function ogImage(): string
    {
        try {
            $logo = function_exists('getSettingValue') ? getSettingValue('logo') : null;
            if (is_string($logo) && $logo !== '') {
                return str_starts_with($logo, 'http') ? $logo : url($logo);
            }
        } catch (\Throwable) {
            // fall through
        }

        return url('/front_web/images/logo.png');
    }

    /**
     * @return list<array{q:string,a:string}>
     */
    private static function indexFaqs(int $total, ?string $catLabel): array
    {
        $brand = self::brand();

        return [
            [
                'q' => 'Is the Nasira CV Designer free?',
                'a' => "Yes. You can browse {$total}+ templates and design resumes in the browser with {$brand}. Candidate accounts can save designs to reopen later.",
            ],
            [
                'q' => 'Can I download my CV as PDF?',
                'a' => 'Yes. Open a template in the visual studio and use Download PDF when your resume looks ready.',
            ],
            [
                'q' => $catLabel ? "What are {$catLabel} CV templates?" : 'What CV template styles are available?',
                'a' => $catLabel
                    ? "{$catLabel} templates are curated layouts for that style. Filter the gallery or open any card to customize it."
                    : 'Choose modern, classic, sidebar, executive, creative, minimal, ATS, and more — each with multiple color ways.',
            ],
            [
                'q' => 'Do I need Canva or design skills?',
                'a' => 'No. The studio is Canva-style but built into Nasira Jobs: pick a template, edit text and blocks visually, then export.',
            ],
        ];
    }

    /**
     * @return list<array{q:string,a:string}>
     */
    private static function templateFaqs(string $name, string $catLabel, string $descriptionRaw): array
    {
        return [
            [
                'q' => "What is the {$name} CV template?",
                'a' => ($descriptionRaw !== '' ? rtrim($descriptionRaw, '.').'. ' : '')
                    ."It is a {$catLabel} resume layout you can edit online in Nasira Jobs CV Designer.",
            ],
            [
                'q' => "Is {$name} free to use?",
                'a' => "Yes. Open {$name} in the CV studio, customize it, and download a PDF for applications.",
            ],
            [
                'q' => "How do I edit the {$name} resume template?",
                'a' => "Click Design this CV, then use the Canva-style editor to change text, colors, images, and section layout.",
            ],
            [
                'q' => "Is {$name} good for ATS?",
                'a' => $catLabel === 'Ats' || stripos($name, 'ATS') !== false
                    ? 'Yes — this layout prioritizes clean structure that applicant tracking systems can parse more reliably.'
                    : 'Many employers accept styled CVs. For strict ATS portals, also try our Compact ATS templates from the gallery.',
            ],
        ];
    }

    /**
     * @return list<array{name:string,text:string}>
     */
    private static function howToSteps(?string $templateName = null): array
    {
        $pick = $templateName
            ? "Open the {$templateName} template in CV Designer."
            : 'Browse the gallery and open a template that matches your role.';

        return [
            ['name' => 'Choose a template', 'text' => $pick],
            ['name' => 'Customize visually', 'text' => 'Edit name, experience, skills, and branding in the Canva-style studio.'],
            ['name' => 'Refine layout', 'text' => 'Drag blocks, adjust colors, and keep an A4-ready preview.'],
            ['name' => 'Download PDF', 'text' => 'Export your resume and apply on Nasira Jobs with confidence.'],
        ];
    }

    /**
     * @param  list<array{q:string,a:string}>  $faqs
     * @return array<string, mixed>
     */
    private static function indexJsonLd(
        string $title,
        string $description,
        string $canonical,
        string $ogImage,
        array $faqs,
        int $total
    ): array {
        $brand = self::brand();

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebApplication',
                    '@id' => $canonical.'#app',
                    'name' => $brand.' CV Designer',
                    'url' => $canonical,
                    'description' => $description,
                    'applicationCategory' => 'BusinessApplication',
                    'operatingSystem' => 'Any',
                    'browserRequirements' => 'Requires JavaScript',
                    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
                    'creator' => ['@type' => 'Organization', 'name' => $brand, 'url' => url('/')],
                    'image' => $ogImage,
                    'isAccessibleForFree' => true,
                ],
                [
                    '@type' => 'CollectionPage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'isPartOf' => ['@type' => 'WebSite', 'name' => $brand, 'url' => url('/')],
                    'about' => ['@id' => $canonical.'#app'],
                    'numberOfItems' => $total,
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'CV Design', 'item' => route('front.cv.design')],
                    ],
                ],
                [
                    '@type' => 'HowTo',
                    'name' => 'How to design a CV online with Nasira',
                    'description' => $description,
                    'totalTime' => 'PT10M',
                    'step' => array_map(static fn (array $step, int $i) => [
                        '@type' => 'HowToStep',
                        'position' => $i + 1,
                        'name' => $step['name'],
                        'text' => $step['text'],
                    ], self::howToSteps(), array_keys(self::howToSteps())),
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(static fn (array $faq) => [
                        '@type' => 'Question',
                        'name' => $faq['q'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
                    ], $faqs),
                ],
            ],
        ];
    }

    /**
     * @param  list<array{q:string,a:string}>  $faqs
     * @param  list<array{name:string,text:string}>  $steps
     * @return array<string, mixed>
     */
    private static function templateJsonLd(
        string $name,
        string $slug,
        string $catLabel,
        string $title,
        string $description,
        string $canonical,
        string $ogImage,
        array $faqs,
        array $steps
    ): array {
        $brand = self::brand();

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebApplication',
                    '@id' => $canonical.'#app',
                    'name' => "{$name} — {$brand} CV Designer",
                    'url' => $canonical,
                    'description' => $description,
                    'applicationCategory' => 'BusinessApplication',
                    'operatingSystem' => 'Any',
                    'browserRequirements' => 'Requires JavaScript',
                    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
                    'creator' => ['@type' => 'Organization', 'name' => $brand, 'url' => url('/')],
                    'image' => $ogImage,
                    'isAccessibleForFree' => true,
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'isPartOf' => ['@type' => 'WebSite', 'name' => $brand, 'url' => url('/')],
                    'about' => [
                        '@type' => 'CreativeWork',
                        'name' => $name.' CV Template',
                        'genre' => $catLabel.' resume',
                        'identifier' => $slug,
                    ],
                    'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $ogImage],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'CV Design', 'item' => route('front.cv.design')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $catLabel, 'item' => route('front.cv.design', ['category' => strtolower($catLabel)])],
                        ['@type' => 'ListItem', 'position' => 4, 'name' => $name, 'item' => $canonical],
                    ],
                ],
                [
                    '@type' => 'HowTo',
                    'name' => "How to edit the {$name} CV template",
                    'description' => $description,
                    'totalTime' => 'PT10M',
                    'step' => array_map(static fn (array $step, int $i) => [
                        '@type' => 'HowToStep',
                        'position' => $i + 1,
                        'name' => $step['name'],
                        'text' => $step['text'],
                    ], $steps, array_keys($steps)),
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(static fn (array $faq) => [
                        '@type' => 'Question',
                        'name' => $faq['q'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
                    ], $faqs),
                ],
            ],
        ];
    }

    private static function clip(string $text, int $max): string
    {
        $text = preg_replace('/\s+/', ' ', trim($text)) ?? trim($text);
        if (mb_strlen($text) <= $max) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, $max - 1)).'…';
    }
}
