<?php

namespace App\Support;

use App\Models\Company;
use App\Models\Job;
use App\Models\Post;
use Illuminate\Support\Str;

/**
 * Site-wide advanced SEO for public front pages (jobs, companies, blogs, static).
 */
class FrontSeo
{
    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function make(
        string $title,
        string $description,
        string $canonical,
        array $keywords = [],
        array $jsonLd = [],
        array $overrides = []
    ): array {
        $brand = self::brand();
        $ogImage = $overrides['og_image'] ?? self::ogImage();
        $description = self::clip($description, 158);
        $fullTitle = $overrides['meta_title'] ?? (str_contains($title, $brand) ? $title : "{$title} | {$brand}");

        $baseJson = $jsonLd !== [] ? $jsonLd : [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $fullTitle,
                    'description' => $description,
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => $brand,
                        'url' => url('/'),
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('front.home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => $title, 'item' => $canonical],
                    ],
                ],
            ],
        ];

        return array_merge([
            'title' => $title,
            'meta_title' => $fullTitle,
            'description' => $description,
            'keywords' => implode(', ', array_values(array_unique(array_filter($keywords)))),
            'canonical' => $canonical,
            'robots' => $overrides['robots'] ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
            'og_type' => $overrides['og_type'] ?? 'website',
            'og_title' => $fullTitle,
            'og_description' => $description,
            'og_url' => $canonical,
            'og_image' => $ogImage,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $fullTitle,
            'twitter_description' => $description,
            'twitter_image' => $ogImage,
            'json_ld' => $baseJson,
        ], $overrides);
    }

    /**
     * Default SEO by named route when a controller does not pass `$seo`.
     *
     * @return array<string, mixed>
     */
    public static function forCurrentRoute(): array
    {
        $route = optional(request()->route())->getName() ?? '';

        return match (true) {
            $route === 'front.home' => self::home(),
            $route === 'front.search.jobs' => self::jobsIndex(request()->all()),
            $route === 'front.company.lists' => self::companiesIndex(),
            $route === 'front.candidate.lists' => self::candidatesIndex(),
            $route === 'front.categories' => self::categories(),
            $route === 'front.about.us' => self::about(),
            $route === 'front.contact' => self::contact(),
            $route === 'privacy.policy.list' => self::privacy(),
            $route === 'terms.conditions.list' => self::terms(),
            $route === 'front.post.lists' => self::blogIndex(),
            $route === 'candidate.register', $route === 'front.register' => self::authPage('Candidate Register', 'Create a free candidate account to apply for jobs on Nasira Jobs.'),
            $route === 'employer.register' => self::authPage('Employer Register', 'Register your company and post jobs on Nasira Jobs.'),
            $route === 'show.apply-job-form' => self::authPage('Apply for Job', 'Submit your application for this job on Nasira Jobs.'),
            str_contains($route, 'login') => self::authPage('Login', 'Sign in to your Nasira Jobs account.'),
            default => self::make(
                self::brand(),
                'Find jobs, build your CV, and use free career tools on '.self::brand().'.',
                url()->current(),
                ['jobs', 'careers', 'nasira jobs']
            ),
        };
    }

    /**
     * @return array<string, mixed>
     */
    public static function home(): array
    {
        $brand = self::brand();
        $canonical = route('front.home');
        $title = "Find Jobs in Ethiopia — {$brand}";
        $description = "Search trusted jobs across Ethiopia, apply with confidence, design your CV, and use free career tools on {$brand}.";

        return self::make($title, $description, $canonical, [
            'jobs in ethiopia',
            'nasira jobs',
            'find jobs',
            'online cv designer',
            'job portal ethiopia',
            'apply for jobs',
        ], [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebSite',
                    '@id' => url('/').'#website',
                    'url' => url('/'),
                    'name' => $brand,
                    'description' => $description,
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => route('front.search.jobs').'?keywords={search_term_string}',
                        'query-input' => 'required name=search_term_string',
                    ],
                ],
                [
                    '@type' => 'Organization',
                    '@id' => url('/').'#organization',
                    'name' => $brand,
                    'url' => url('/'),
                    'logo' => self::ogImage(),
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'isPartOf' => ['@id' => url('/').'#website'],
                    'about' => ['@id' => url('/').'#organization'],
                ],
            ],
        ], ['meta_title' => $title]);
    }

    /**
     * @param  array<string, mixed>  $input
     * @return array<string, mixed>
     */
    public static function jobsIndex(array $input = []): array
    {
        $brand = self::brand();
        $keywordsQuery = trim((string) ($input['keywords'] ?? $input['search'] ?? ''));
        $canonical = route('front.search.jobs');

        if ($keywordsQuery !== '') {
            $title = "{$keywordsQuery} Jobs — Search Results | {$brand}";
            $description = "Browse {$keywordsQuery} job openings on {$brand}. Filter by location, category, and type — apply online today.";
            $canonical = route('front.search.jobs', array_filter([
                'keywords' => $input['keywords'] ?? null,
                'search' => $input['search'] ?? null,
            ]));
        } else {
            $title = "Find Jobs Online — Search Latest Vacancies | {$brand}";
            $description = "Search the latest job vacancies on {$brand}. Discover openings by category, company, and location — apply in minutes.";
        }

        return self::make($title, $description, $canonical, [
            'find jobs',
            'job search',
            'job vacancies',
            'jobs in ethiopia',
            'latest jobs',
            $keywordsQuery !== '' ? strtolower($keywordsQuery).' jobs' : null,
            'nasira jobs',
        ], [], ['meta_title' => $title]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function forJob(Job $job): array
    {
        $brand = self::brand();
        $jobTitle = html_entity_decode(strip_tags((string) $job->job_title));
        $companyName = html_entity_decode(strip_tags((string) ($job->company?->user?->full_name ?? 'Employer')));
        $location = trim((string) ($job->full_location ?? ''));
        $category = (string) ($job->jobCategory?->name ?? 'Jobs');
        $jobType = (string) ($job->jobType?->name ?? '');
        $plain = self::plainText((string) $job->description);
        $canonical = route('front.job.details', $job->job_id);

        $title = "{$jobTitle} at {$companyName}".($location !== '' ? " — {$location}" : '')." | {$brand}";
        $description = self::clip(
            ($plain !== '' ? $plain : "Apply for {$jobTitle} at {$companyName} on {$brand}.")
            .' '.($jobType !== '' ? "{$jobType}. " : '')
            ."View salary, requirements, and apply online.",
            158
        );

        $keywords = array_filter([
            strtolower($jobTitle),
            strtolower($jobTitle).' job',
            strtolower($companyName).' careers',
            strtolower($category).' jobs',
            $location !== '' ? strtolower($location).' jobs' : null,
            $jobType !== '' ? strtolower($jobType) : null,
            'apply online',
            'nasira jobs',
        ]);

        $ogImage = $job->company?->company_url ?: self::ogImage();
        $jsonLd = self::jobPostingGraph($job, $title, $description, $canonical, $ogImage, $jobTitle, $companyName, $location);

        return self::make($title, $description, $canonical, $keywords, $jsonLd, [
            'meta_title' => $title,
            'og_type' => 'article',
            'og_image' => $ogImage,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function companiesIndex(): array
    {
        $brand = self::brand();
        $title = "Top Companies Hiring — Employer Directory | {$brand}";
        $description = "Explore companies hiring on {$brand}. Browse employer profiles, open roles, and find your next workplace.";

        return self::make($title, $description, route('front.company.lists'), [
            'companies hiring',
            'employer directory',
            'company jobs',
            'nasira jobs companies',
        ], [], ['meta_title' => $title]);
    }

    /**
     * @param  array<string, mixed>  $data  company_details view payload
     * @return array<string, mixed>
     */
    public static function forCompany($company): array
    {
        $brand = self::brand();
        $name = html_entity_decode(strip_tags((string) ($company->user->full_name ?? 'Company')));
        $uniqueId = (string) ($company->unique_id ?? '');
        $location = trim(implode(', ', array_filter([
            $company->user->city_name ?? null,
            $company->user->state_name ?? null,
            $company->user->country_name ?? null,
        ])));
        $about = self::plainText((string) ($company->details ?? $company->user->about_me ?? ''));
        $canonical = route('front.company.details', $uniqueId);
        $title = "{$name} Careers & Jobs".($location !== '' ? " in {$location}" : '')." | {$brand}";
        $description = self::clip(
            ($about !== '' ? $about : "View {$name} company profile, culture, and open job vacancies on {$brand}."),
            158
        );
        $ogImage = $company->company_url ?? self::ogImage();

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => $canonical.'#organization',
                    'name' => $name,
                    'url' => $canonical,
                    'logo' => $ogImage,
                    'description' => $description,
                ],
                [
                    '@type' => 'ProfilePage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'mainEntity' => ['@id' => $canonical.'#organization'],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('front.home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Companies', 'item' => route('front.company.lists')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $name, 'item' => $canonical],
                    ],
                ],
            ],
        ];

        return self::make($title, $description, $canonical, [
            strtolower($name),
            strtolower($name).' jobs',
            strtolower($name).' careers',
            'company profile',
            'hiring company',
        ], $jsonLd, [
            'meta_title' => $title,
            'og_image' => $ogImage,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function candidatesIndex(): array
    {
        $brand = self::brand();
        $title = "Find Candidates — Talent Directory | {$brand}";
        $description = "Browse candidate profiles on {$brand} and connect with talent ready for your open roles.";

        return self::make($title, $description, route('front.candidate.lists'), [
            'find candidates',
            'talent directory',
            'hire talent',
            'nasira jobs candidates',
        ], [], [
            'meta_title' => $title,
            'robots' => 'noindex, follow',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function forCandidate($candidate): array
    {
        $brand = self::brand();
        $name = html_entity_decode(strip_tags((string) ($candidate->user->full_name ?? 'Candidate')));
        $role = (string) ($candidate->functionalArea->name ?? 'Professional');
        $uniqueId = (string) ($candidate->unique_id ?? '');
        $canonical = route('front.candidate.details', $uniqueId);
        $title = "{$name} — {$role} Profile | {$brand}";
        $description = self::clip(
            "View {$name}'s candidate profile ({$role}) on {$brand}. Experience, education, and skills for employers.",
            158
        );

        return self::make($title, $description, $canonical, [
            strtolower($name),
            strtolower($role),
            'candidate profile',
            'hire '.$role,
        ], [], [
            'meta_title' => $title,
            'robots' => 'noindex, follow',
            'og_image' => $candidate->user->avatar ?? self::ogImage(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function categories(): array
    {
        $brand = self::brand();
        $title = "Job Categories — Browse Roles by Industry | {$brand}";
        $description = "Explore job categories on {$brand} and jump into openings that match your skills and industry.";

        return self::make($title, $description, route('front.categories'), [
            'job categories',
            'jobs by industry',
            'career categories',
            'nasira jobs',
        ], [], ['meta_title' => $title]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function about(): array
    {
        $brand = self::brand();
        $title = "About Us & FAQ — {$brand}";
        $description = "Learn about {$brand}, our mission to connect talent with opportunity, and answers to frequently asked questions.";

        return self::make($title, $description, route('front.about.us'), [
            'about nasira jobs',
            'job portal faq',
            'career platform ethiopia',
        ], [], ['meta_title' => $title]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function contact(): array
    {
        $brand = self::brand();
        $title = "Contact Us — {$brand}";
        $description = "Contact {$brand} support for help with job applications, employer accounts, or platform questions.";

        return self::make($title, $description, route('front.contact'), [
            'contact nasira jobs',
            'job portal support',
            'customer support',
        ], [], ['meta_title' => $title]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function privacy(): array
    {
        $brand = self::brand();
        $title = "Privacy Policy — {$brand}";
        $description = "Read how {$brand} collects, uses, and protects your personal data.";

        return self::make($title, $description, route('privacy.policy.list'), [
            'privacy policy',
            'data protection',
            'nasira jobs privacy',
        ], [], ['meta_title' => $title]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function terms(): array
    {
        $brand = self::brand();
        $title = "Terms & Conditions — {$brand}";
        $description = "Review the terms and conditions for using {$brand} as a candidate or employer.";

        return self::make($title, $description, route('terms.conditions.list'), [
            'terms and conditions',
            'user agreement',
            'nasira jobs terms',
        ], [], ['meta_title' => $title]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function blogIndex(): array
    {
        $brand = self::brand();
        $title = "Career Blog & Job Tips — {$brand}";
        $description = "Read career advice, hiring tips, and job-market insights from the {$brand} blog.";

        return self::make($title, $description, route('front.post.lists'), [
            'career blog',
            'job tips',
            'hiring advice',
            'nasira jobs blog',
        ], [], ['meta_title' => $title]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function forBlog(Post $post): array
    {
        $brand = self::brand();
        $postTitle = html_entity_decode(strip_tags((string) $post->title));
        $plain = self::plainText((string) $post->description);
        $canonical = route('front.posts.details', $post);
        $title = "{$postTitle} | {$brand} Blog";
        $description = self::clip($plain !== '' ? $plain : "Read {$postTitle} on the {$brand} career blog.", 158);

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'BlogPosting',
                    '@id' => $canonical.'#article',
                    'headline' => $postTitle,
                    'description' => $description,
                    'datePublished' => optional($post->created_at)?->toAtomString(),
                    'dateModified' => optional($post->updated_at)?->toAtomString(),
                    'mainEntityOfPage' => $canonical,
                    'author' => ['@type' => 'Organization', 'name' => $brand],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => $brand,
                        'logo' => ['@type' => 'ImageObject', 'url' => self::ogImage()],
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('front.home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('front.post.lists')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $postTitle, 'item' => $canonical],
                    ],
                ],
            ],
        ];

        return self::make($title, $description, $canonical, [
            strtolower($postTitle),
            'career tips',
            'job blog',
            'nasira jobs blog',
        ], $jsonLd, [
            'meta_title' => $title,
            'og_type' => 'article',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public static function authPage(string $title, string $description): array
    {
        return self::make($title, $description, url()->current(), [
            strtolower($title),
            'nasira jobs account',
        ], [], [
            'meta_title' => $title.' | '.self::brand(),
            'robots' => 'noindex, follow',
        ]);
    }

    /**
     * @return list<array{loc:string,lastmod?:string,changefreq?:string,priority?:string}>
     */
    public static function pagesSitemapEntries(): array
    {
        $now = now()->toAtomString();
        $pages = [
            ['route' => 'front.home', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['route' => 'front.search.jobs', 'priority' => '0.95', 'changefreq' => 'hourly'],
            ['route' => 'front.company.lists', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['route' => 'front.categories', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['route' => 'front.about.us', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['route' => 'front.contact', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['route' => 'privacy.policy.list', 'priority' => '0.4', 'changefreq' => 'yearly'],
            ['route' => 'terms.conditions.list', 'priority' => '0.4', 'changefreq' => 'yearly'],
            ['route' => 'front.post.lists', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['route' => 'front.solutions', 'priority' => '0.85', 'changefreq' => 'weekly'],
            ['route' => 'front.cv.design', 'priority' => '0.85', 'changefreq' => 'weekly'],
        ];

        $entries = [];
        foreach ($pages as $page) {
            try {
                $entries[] = [
                    'loc' => route($page['route']),
                    'lastmod' => $now,
                    'changefreq' => $page['changefreq'],
                    'priority' => $page['priority'],
                ];
            } catch (\Throwable) {
                // skip missing named routes
            }
        }

        return $entries;
    }

    /**
     * @return list<array{loc:string,lastmod:string,changefreq:string,priority:string}>
     */
    public static function jobsSitemapEntries(int $limit = 2000): array
    {
        return Job::query()
            ->where('status', Job::STATUS_OPEN)
            ->whereDate('job_expiry_date', '>=', now()->toDateString())
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get(['job_id', 'updated_at'])
            ->map(static fn (Job $job) => [
                'loc' => route('front.job.details', $job->job_id),
                'lastmod' => optional($job->updated_at)?->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ])
            ->all();
    }

    /**
     * @return list<array{loc:string,lastmod:string,changefreq:string,priority:string}>
     */
    public static function companiesSitemapEntries(int $limit = 1000): array
    {
        return Company::query()
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get(['unique_id', 'updated_at'])
            ->map(static fn (Company $company) => [
                'loc' => route('front.company.details', $company->unique_id),
                'lastmod' => optional($company->updated_at)?->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ])
            ->all();
    }

    /**
     * @return list<array{loc:string,lastmod:string,changefreq:string,priority:string}>
     */
    public static function postsSitemapEntries(int $limit = 500): array
    {
        return Post::query()
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get(['id', 'updated_at'])
            ->map(static fn (Post $post) => [
                'loc' => route('front.posts.details', $post),
                'lastmod' => optional($post->updated_at)?->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ])
            ->all();
    }

    /**
     * @return list<array{loc:string}>
     */
    public static function sitemapIndexEntries(): array
    {
        return [
            ['loc' => route('front.sitemap.pages')],
            ['loc' => route('front.sitemap.jobs')],
            ['loc' => route('front.sitemap.companies')],
            ['loc' => route('front.sitemap.posts')],
            ['loc' => route('front.solutions.sitemap')],
            ['loc' => route('front.cv.sitemap')],
        ];
    }

    private static function jobPostingGraph(
        Job $job,
        string $title,
        string $description,
        string $canonical,
        string $ogImage,
        string $jobTitle,
        string $companyName,
        string $location
    ): array {
        $brand = self::brand();
        $datePosted = optional($job->created_at)?->toAtomString() ?? now()->toAtomString();
        $validThrough = optional($job->job_expiry_date)?->endOfDay()?->toAtomString();

        $jobPosting = [
            '@type' => 'JobPosting',
            '@id' => $canonical.'#job',
            'title' => $jobTitle,
            'description' => $description,
            'datePosted' => $datePosted,
            'hiringOrganization' => array_filter([
                '@type' => 'Organization',
                'name' => $companyName,
                'sameAs' => ! empty($job->company?->unique_id)
                    ? route('front.company.details', $job->company->unique_id)
                    : null,
                'logo' => $ogImage,
            ]),
            'identifier' => [
                '@type' => 'PropertyValue',
                'name' => $brand,
                'value' => (string) $job->job_id,
            ],
            'url' => $canonical,
            'directApply' => true,
        ];

        if ($validThrough) {
            $jobPosting['validThrough'] = $validThrough;
        }

        $employment = self::employmentType($job->jobType->name ?? null);
        if ($employment) {
            $jobPosting['employmentType'] = $employment;
        }

        if ($location !== '') {
            $jobPosting['jobLocation'] = [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job->city_name ?? $location,
                    'addressRegion' => $job->state_name ?? null,
                    'addressCountry' => $job->country_name ?? 'ET',
                ],
            ];
        }

        if (! $job->hide_salary && ($job->salary_from || $job->salary_to)) {
            $currency = $job->currency->currency_code
                ?? $job->currency->code
                ?? $job->currency->currency_icon
                ?? 'ETB';
            $jobPosting['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => preg_replace('/[^A-Z]/', '', strtoupper((string) $currency)) ?: 'ETB',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => $job->salary_from,
                    'maxValue' => $job->salary_to ?: $job->salary_from,
                    'unitText' => strtoupper((string) ($job->salaryPeriod->period ?? 'MONTH')),
                ],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $jobPosting,
                [
                    '@type' => 'WebPage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $ogImage],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('front.home')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Jobs', 'item' => route('front.search.jobs')],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $jobTitle, 'item' => $canonical],
                    ],
                ],
            ],
        ];
    }

    private static function employmentType(?string $name): ?string
    {
        if (! $name) {
            return null;
        }
        $n = strtolower($name);

        return match (true) {
            str_contains($n, 'full') => 'FULL_TIME',
            str_contains($n, 'part') => 'PART_TIME',
            str_contains($n, 'contract') => 'CONTRACTOR',
            str_contains($n, 'temp') => 'TEMPORARY',
            str_contains($n, 'intern') => 'INTERN',
            str_contains($n, 'volunteer') => 'VOLUNTEER',
            str_contains($n, 'freelance') || str_contains($n, 'remote') => 'OTHER',
            default => 'OTHER',
        };
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

    private static function plainText(string $html): string
    {
        $text = html_entity_decode(strip_tags($html));

        return trim(preg_replace('/\s+/', ' ', $text) ?? $text);
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
