<?php

namespace App\Support;

/**
 * Advanced SEO payloads for every Nasira Solutions tool page.
 */
class SolutionsSeo
{
    /**
     * @param  array<string, mixed>  $tool
     * @return array<string, mixed>
     */
    public static function forTool(array $tool): array
    {
        $name = (string) ($tool['name'] ?? 'Online Tool');
        $desc = trim((string) ($tool['desc'] ?? ''));
        $slug = (string) ($tool['slug'] ?? '');
        $section = (string) ($tool['section'] ?? 'Tools');
        $groupTitle = (string) ($tool['group_title'] ?? $section);
        $outputs = array_values(array_filter((array) ($tool['outputs'] ?? [])));
        $engine = (string) ($tool['engine'] ?? 'special');
        $brand = self::brand();

        $action = self::actionVerb($name, $section, $engine);
        $formats = self::formatPhrase($name, $outputs);
        $privacy = 'Runs privately in your browser — files stay on your device.';

        $title = self::titleFor($name, $action, $formats, $section);
        $description = self::descriptionFor($name, $desc, $action, $formats, $privacy, $brand);
        $keywords = self::keywordsFor($name, $slug, $section, $groupTitle, $outputs, $action);
        $canonical = route('front.solutions.show', $slug);
        $ogImage = self::ogImage();

        $faqs = self::faqsFor($name, $desc, $formats, $privacy, $section, $engine);
        $steps = self::howToSteps($name, $action, $formats);
        $intro = self::introCopy($name, $desc, $action, $formats, $privacy, $brand);
        $benefits = self::benefits($name, $section, $privacy);

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
            'intro' => $intro,
            'benefits' => $benefits,
            'faqs' => $faqs,
            'howto_steps' => $steps,
            'json_ld' => self::jsonLdBundle($tool, $title, $description, $canonical, $ogImage, $faqs, $steps, $action),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function forIndex(int $total): array
    {
        $brand = self::brand();
        $title = "Free Online File Converters & Tools ({$total}+) — {$brand}";
        $description = "Convert, compress, and edit video, audio, images, PDF, and GIF online with {$total}+ free browser tools from {$brand}. Private by design — no signup required.";
        $canonical = route('front.solutions');
        $ogImage = self::ogImage();
        $keywords = [
            'free online converter',
            'file converter',
            'compress PDF',
            'image converter',
            'video converter',
            'background remover',
            'Nasira Jobs tools',
            'browser file tools',
        ];

        $faqs = [
            [
                'q' => 'Are Nasira Solutions tools free?',
                'a' => "Yes. All {$total}+ tools on the Solutions hub are free to use in your browser.",
            ],
            [
                'q' => 'Do you upload my files to a server?',
                'a' => 'No. Conversions and edits run locally in your browser whenever possible, so your files stay on your device.',
            ],
            [
                'q' => 'What file types can I convert?',
                'a' => 'Video, audio, images, PDF, GIF, archives, and career helpers — browse Convert, Compress, Tools, and Career sections.',
            ],
        ];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'isPartOf' => ['@type' => 'WebSite', 'name' => $brand, 'url' => url('/')],
                    'about' => [
                        '@type' => 'Thing',
                        'name' => 'Online file conversion and compression tools',
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Solutions', 'item' => $canonical],
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(static fn (array $faq) => [
                        '@type' => 'Question',
                        'name' => $faq['q'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['a'],
                        ],
                    ], $faqs),
                ],
                [
                    '@type' => 'ItemList',
                    'name' => 'Nasira Solutions catalog',
                    'numberOfItems' => $total,
                    'itemListElement' => self::indexItemListElements(),
                ],
            ],
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
            'faqs' => $faqs,
            'json_ld' => $jsonLd,
        ];
    }

    /**
     * @return list<array{loc:string,lastmod:string,changefreq:string,priority:string}>
     */
    public static function sitemapEntries(): array
    {
        $now = now()->toAtomString();
        $entries = [[
            'loc' => route('front.solutions'),
            'lastmod' => $now,
            'changefreq' => 'weekly',
            'priority' => '0.9',
        ]];

        foreach (SolutionsCatalog::allItems() as $item) {
            if (! empty($item['route'])) {
                continue;
            }
            $entries[] = [
                'loc' => route('front.solutions.show', $item['slug']),
                'lastmod' => $now,
                'changefreq' => 'monthly',
                'priority' => '0.8',
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

    private static function actionVerb(string $name, string $section, string $engine): string
    {
        $lower = strtolower($name);
        if (str_contains($lower, 'compress') || $section === 'Compress') {
            return 'Compress';
        }
        if (str_contains($lower, 'remove') || str_contains($lower, 'crop') || str_contains($lower, 'resize')) {
            return 'Edit';
        }
        if (str_contains($lower, 'generator') || str_contains($lower, 'maker') || str_contains($lower, 'picker')) {
            return 'Create';
        }
        if (str_contains($lower, 'counter') || str_contains($lower, 'calculator') || str_contains($lower, 'checker')) {
            return 'Analyze';
        }
        if ($section === 'Career' || $engine === 'route') {
            return 'Use';
        }

        return 'Convert';
    }

    /**
     * @param  list<string>  $outputs
     */
    private static function formatPhrase(string $name, array $outputs): string
    {
        if (preg_match('/^(.+?)\s+to\s+(.+)$/i', $name, $m)) {
            return trim($m[1]).' to '.trim($m[2]);
        }

        if ($outputs !== []) {
            $upper = array_map(static fn ($f) => strtoupper((string) $f), $outputs);

            return implode(', ', $upper);
        }

        return $name;
    }

    private static function titleFor(string $name, string $action, string $formats, string $section): string
    {
        $brand = self::brand();

        if ($action === 'Convert' && stripos($name, ' to ') !== false) {
            return "{$name} Online Free — Fast {$formats} Converter | {$brand}";
        }

        if ($action === 'Compress') {
            return "{$name} Online Free — Shrink Files Fast | {$brand}";
        }

        if ($section === 'Career') {
            return "{$name} — Free Career Tool | {$brand}";
        }

        return "Free Online {$name} — {$action} Instantly | {$brand}";
    }

    private static function descriptionFor(
        string $name,
        string $desc,
        string $action,
        string $formats,
        string $privacy,
        string $brand
    ): string {
        $base = $desc !== '' ? rtrim($desc, '.') : "{$action} files online with {$name}";
        $extra = " Free {$name} by {$brand}. {$privacy}";
        if ($formats !== $name) {
            $extra = " Supports {$formats}.".$extra;
        }

        $text = $base.'.'.$extra;

        return self::clip($text, 158);
    }

    /**
     * @param  list<string>  $outputs
     * @return list<string>
     */
    private static function keywordsFor(
        string $name,
        string $slug,
        string $section,
        string $groupTitle,
        array $outputs,
        string $action
    ): array {
        $keywords = [
            strtolower($name),
            strtolower($name).' online',
            'free '.strtolower($name),
            str_replace('-', ' ', $slug),
            strtolower($action).' online',
            strtolower($section).' tool',
            strtolower($groupTitle),
            'nasira jobs',
            'browser tool',
            'no signup',
        ];

        foreach ($outputs as $format) {
            $keywords[] = strtolower((string) $format).' converter';
            $keywords[] = 'free '.strtolower((string) $format).' tool';
        }

        if (stripos($name, ' to ') !== false) {
            $keywords[] = strtolower($name).' converter';
            $keywords[] = strtolower($name).' free';
        }

        return array_values(array_unique(array_filter($keywords)));
    }

    /**
     * @return list<array{q:string,a:string}>
     */
    private static function faqsFor(
        string $name,
        string $desc,
        string $formats,
        string $privacy,
        string $section,
        string $engine
    ): array {
        $what = $desc !== '' ? $desc : "{$name} helps you {$formats} online in a few clicks.";

        $faqs = [
            [
                'q' => "What is {$name}?",
                'a' => $what.' Available free on Nasira Jobs Solutions.',
            ],
            [
                'q' => "Is {$name} free to use?",
                'a' => "Yes. {$name} is free — no account required for standard use.",
            ],
            [
                'q' => "Are my files uploaded when I use {$name}?",
                'a' => $privacy.' Processing stays on-device whenever the tool engine allows.',
            ],
            [
                'q' => "How do I use {$name}?",
                'a' => "Open {$name}, upload or enter your input, choose options if shown, then download or copy the result.",
            ],
        ];

        if ($formats !== $name) {
            $faqs[] = [
                'q' => "Which formats does {$name} support?",
                'a' => "{$name} focuses on {$formats}. Check the tool panel for exact input types accepted in your browser.",
            ];
        }

        if ($section === 'Compress') {
            $faqs[] = [
                'q' => 'Will quality drop after compression?',
                'a' => 'Compression balances size and quality. Use a higher quality setting when detail matters, or lower settings for smaller uploads.',
            ];
        }

        if (in_array($engine, ['ffmpeg', 'heic'], true)) {
            $faqs[] = [
                'q' => "Why does {$name} take time on first use?",
                'a' => 'Some media tools load a browser engine on first run. Later conversions are typically faster on the same device.',
            ];
        }

        return $faqs;
    }

    /**
     * @return list<array{name:string,text:string}>
     */
    private static function howToSteps(string $name, string $action, string $formats): array
    {
        return [
            [
                'name' => "Open {$name}",
                'text' => "Go to the free {$name} page on Nasira Jobs Solutions.",
            ],
            [
                'name' => 'Add your file or input',
                'text' => 'Upload a file or paste text, depending on the tool.',
            ],
            [
                'name' => "Choose {$action} options",
                'text' => $formats !== $name
                    ? "Select output settings such as {$formats} when available."
                    : 'Adjust quality, size, or other options shown in the panel.',
            ],
            [
                'name' => 'Download your result',
                'text' => 'Run the tool and save the output to your device instantly.',
            ],
        ];
    }

    private static function introCopy(
        string $name,
        string $desc,
        string $action,
        string $formats,
        string $privacy,
        string $brand
    ): string {
        $lead = $desc !== '' ? rtrim($desc, '.') : "Use {$name} to {$action} files online";
        $mid = $formats !== $name ? " Ideal when you need {$formats} quickly." : '';

        return "{$lead} with {$brand}'s free {$name}.{$mid} {$privacy}";
    }

    /**
     * @return list<string>
     */
    private static function benefits(string $name, string $section, string $privacy): array
    {
        return [
            "Free online {$name} — no signup wall for standard use",
            $privacy,
            'Works on desktop and mobile browsers',
            $section === 'Career'
                ? 'Built for job seekers preparing applications faster'
                : 'Fast convert / compress workflow inspired by FreeConvert-style tools',
            'Related Nasira tools nearby so you can finish multi-step file tasks',
        ];
    }

    /**
     * @param  array<string, mixed>  $tool
     * @param  list<array{q:string,a:string}>  $faqs
     * @param  list<array{name:string,text:string}>  $steps
     * @return array<string, mixed>
     */
    private static function jsonLdBundle(
        array $tool,
        string $title,
        string $description,
        string $canonical,
        string $ogImage,
        array $faqs,
        array $steps,
        string $action
    ): array {
        $brand = self::brand();
        $name = (string) ($tool['name'] ?? 'Tool');
        $section = (string) ($tool['section'] ?? 'Tools');

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebApplication',
                    '@id' => $canonical.'#app',
                    'name' => $name,
                    'url' => $canonical,
                    'description' => $description,
                    'applicationCategory' => 'UtilitiesApplication',
                    'operatingSystem' => 'Any',
                    'browserRequirements' => 'Requires JavaScript',
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => '0',
                        'priceCurrency' => 'USD',
                    ],
                    'creator' => [
                        '@type' => 'Organization',
                        'name' => $brand,
                        'url' => url('/'),
                    ],
                    'image' => $ogImage,
                    'isAccessibleForFree' => true,
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => $brand,
                        'url' => url('/'),
                    ],
                    'about' => ['@id' => $canonical.'#app'],
                    'primaryImageOfPage' => [
                        '@type' => 'ImageObject',
                        'url' => $ogImage,
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => array_values(array_filter([
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Solutions', 'item' => route('front.solutions')],
                        $section !== ''
                            ? ['@type' => 'ListItem', 'position' => 3, 'name' => $section, 'item' => route('front.solutions').'#section-'.$section]
                            : null,
                        ['@type' => 'ListItem', 'position' => $section !== '' ? 4 : 3, 'name' => $name, 'item' => $canonical],
                    ])),
                ],
                [
                    '@type' => 'HowTo',
                    'name' => "How to {$action} with {$name}",
                    'description' => $description,
                    'totalTime' => 'PT2M',
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
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['a'],
                        ],
                    ], $faqs),
                ],
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private static function indexItemListElements(): array
    {
        $elements = [];
        $position = 1;
        foreach (SolutionsCatalog::allItems() as $item) {
            if (! empty($item['route'])) {
                continue;
            }
            $elements[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $item['name'],
                'url' => route('front.solutions.show', $item['slug']),
            ];
            if ($position > 40) {
                break;
            }
        }

        return $elements;
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
