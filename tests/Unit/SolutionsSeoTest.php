<?php

namespace Tests\Unit;

use App\Support\SolutionsCatalog;
use App\Support\SolutionsSeo;
use Tests\TestCase;

class SolutionsSeoTest extends TestCase
{
    public function test_every_catalog_tool_gets_unique_seo_payload(): void
    {
        $titles = [];

        foreach (SolutionsCatalog::allItems() as $tool) {
            if (! empty($tool['route'])) {
                continue;
            }

            $seo = SolutionsSeo::forTool($tool);

            $this->assertNotEmpty($seo['title'], $tool['slug']);
            $this->assertNotEmpty($seo['description'], $tool['slug']);
            $this->assertNotEmpty($seo['keywords'], $tool['slug']);
            $this->assertStringContainsString('/solutions/'.$tool['slug'], $seo['canonical']);
            $this->assertGreaterThanOrEqual(4, count($seo['faqs']), $tool['slug']);
            $this->assertCount(4, $seo['howto_steps'], $tool['slug']);
            $this->assertArrayHasKey('@graph', $seo['json_ld']);
            $types = array_column($seo['json_ld']['@graph'], '@type');
            $this->assertContains('WebApplication', $types, $tool['slug']);
            $this->assertContains('FAQPage', $types, $tool['slug']);
            $this->assertContains('HowTo', $types, $tool['slug']);
            $this->assertContains('BreadcrumbList', $types, $tool['slug']);
            $this->assertLessThanOrEqual(160, mb_strlen($seo['description']), $tool['slug']);
            $this->assertStringContainsString(strtolower($tool['name']), strtolower($seo['keywords']));

            $titles[$seo['title']] = ($titles[$seo['title']] ?? 0) + 1;
        }

        foreach ($titles as $title => $count) {
            $this->assertSame(1, $count, "Duplicate SEO title: {$title}");
        }
    }

    public function test_index_seo_and_sitemap_cover_all_tools(): void
    {
        $total = SolutionsCatalog::count();
        $seo = SolutionsSeo::forIndex($total);

        $this->assertStringContainsString((string) $total, $seo['title']);
        $this->assertNotEmpty($seo['description']);
        $this->assertArrayHasKey('@graph', $seo['json_ld']);

        $entries = SolutionsSeo::sitemapEntries();
        $toolPages = count(array_filter(
            SolutionsCatalog::allItems(),
            static fn (array $item) => empty($item['route'])
        ));

        $this->assertCount($toolPages + 1, $entries);
        $this->assertSame('0.9', $entries[0]['priority']);
    }

    public function test_solution_pages_expose_seo_meta_and_json_ld(): void
    {
        $this->get(route('front.solutions'))
            ->assertOk()
            ->assertSee('name="description"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('rel="canonical"', false);

        $this->get(route('front.solutions.show', 'background-remover'))
            ->assertOk()
            ->assertSee('Background Remover', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('About Background Remover', false)
            ->assertSee('Background Remover FAQ', false);

        $this->get(route('front.solutions.sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset', false)
            ->assertSee('/solutions/background-remover', false);
    }
}
