<?php

namespace Tests\Unit;

use App\Support\CvDesignSeo;
use App\Support\CvTemplateCatalog;
use Tests\TestCase;

class CvDesignSeoTest extends TestCase
{
    public function test_every_catalog_template_gets_unique_seo(): void
    {
        $titles = [];

        foreach (CvTemplateCatalog::all() as $template) {
            $seo = CvDesignSeo::forTemplate($template);

            $this->assertNotEmpty($seo['title'], $template['slug']);
            $this->assertNotEmpty($seo['description'], $template['slug']);
            $this->assertNotEmpty($seo['keywords'], $template['slug']);
            $this->assertStringContainsString('/cv-design/editor/'.$template['slug'], $seo['canonical']);
            $this->assertGreaterThanOrEqual(4, count($seo['faqs']), $template['slug']);
            $this->assertCount(4, $seo['howto_steps'], $template['slug']);
            $this->assertLessThanOrEqual(160, mb_strlen($seo['description']), $template['slug']);

            $types = array_column($seo['json_ld']['@graph'], '@type');
            $this->assertContains('WebApplication', $types, $template['slug']);
            $this->assertContains('FAQPage', $types, $template['slug']);
            $this->assertContains('HowTo', $types, $template['slug']);
            $this->assertContains('BreadcrumbList', $types, $template['slug']);

            $titles[$seo['title']] = ($titles[$seo['title']] ?? 0) + 1;
        }

        foreach ($titles as $title => $count) {
            $this->assertSame(1, $count, "Duplicate CV SEO title: {$title}");
        }
    }

    public function test_index_and_sitemap_seo(): void
    {
        $total = CvTemplateCatalog::count();
        $seo = CvDesignSeo::forIndex($total);
        $this->assertStringContainsString((string) $total, $seo['title']);
        $this->assertArrayHasKey('@graph', $seo['json_ld']);

        $categorySeo = CvDesignSeo::forIndex($total, 'modern');
        $this->assertStringContainsString('Modern', $categorySeo['title']);
        $this->assertStringContainsString('category=modern', $categorySeo['canonical']);

        $personal = CvDesignSeo::forTemplate(CvTemplateCatalog::all()['nasira-modern'], true);
        $this->assertStringContainsString('noindex', $personal['robots']);

        $entries = CvDesignSeo::sitemapEntries();
        $this->assertGreaterThan($total, count($entries));
        $this->assertSame('0.9', $entries[0]['priority']);
    }

    public function test_cv_pages_expose_seo_meta(): void
    {
        $this->get(route('front.cv.design'))
            ->assertOk()
            ->assertSee('name="description"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('CV Designer FAQ', false);

        $this->get(route('front.cv.editor', 'nasira-modern'))
            ->assertOk()
            ->assertSee('name="description"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('Nasira Modern', false);

        $this->get(route('front.cv.sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset', false)
            ->assertSee('/cv-design/editor/nasira-modern', false);
    }
}
