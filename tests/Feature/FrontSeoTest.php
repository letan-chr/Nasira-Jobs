<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Support\FrontSeo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FrontSeoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_static_front_pages_include_seo_meta(): void
    {
        foreach ([
            route('front.home'),
            route('front.search.jobs'),
            route('front.company.lists'),
            route('front.categories'),
            route('front.about.us'),
            route('front.contact'),
            route('privacy.policy.list'),
            route('terms.conditions.list'),
            route('front.post.lists'),
        ] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('name="description"', false)
                ->assertSee('rel="canonical"', false)
                ->assertSee('application/ld+json', false);
        }
    }

    public function test_job_details_seo_includes_job_posting_schema_when_job_exists(): void
    {
        $job = Job::query()
            ->where('status', Job::STATUS_OPEN)
            ->whereDate('job_expiry_date', '>=', now()->toDateString())
            ->latest('id')
            ->first();

        if (! $job) {
            $this->markTestSkipped('No open jobs available for SEO feature test.');
        }

        $seo = FrontSeo::forJob($job->loadMissing([
            'company.user',
            'jobCategory',
            'jobType',
            'currency',
            'salaryPeriod',
        ]));

        $this->assertStringContainsString($job->job_title, html_entity_decode($seo['meta_title']));
        $types = array_column($seo['json_ld']['@graph'], '@type');
        $this->assertContains('JobPosting', $types);

        $this->get(route('front.job.details', $job->job_id))
            ->assertOk()
            ->assertSee('name="description"', false)
            ->assertSee('JobPosting', false)
            ->assertSee('<h1', false);
    }

    public function test_sitemap_index_and_child_sitemaps_respond(): void
    {
        $this->get(route('front.sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<sitemapindex', false)
            ->assertSee('sitemap-jobs.xml', false);

        $this->get(route('front.sitemap.pages'))
            ->assertOk()
            ->assertSee('<urlset', false)
            ->assertSee(route('front.home'), false);

        $this->get(route('front.sitemap.jobs'))
            ->assertOk()
            ->assertSee('<urlset', false);
    }
}
