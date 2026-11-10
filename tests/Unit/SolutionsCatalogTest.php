<?php

namespace Tests\Unit;

use App\Support\SolutionsCatalog;
use PHPUnit\Framework\TestCase;

class SolutionsCatalogTest extends TestCase
{
    public function test_catalog_has_no_duplicate_slugs(): void
    {
        $slugs = [];
        foreach (SolutionsCatalog::groups() as $group) {
            foreach ($group['items'] as $item) {
                $slug = $item['slug'];
                $this->assertArrayNotHasKey($slug, $slugs, "Duplicate slug: {$slug}");
                $slugs[$slug] = true;
            }
        }

        $this->assertGreaterThan(40, count($slugs));
    }

    public function test_legacy_aliases_resolve(): void
    {
        $this->assertSame('word-to-pdf', SolutionsCatalog::find('docx-to-pdf')['slug']);
        $this->assertSame('timezone-converter', SolutionsCatalog::find('time-converter')['slug']);
    }

    public function test_fragile_tools_carry_notes(): void
    {
        $this->assertNotEmpty(SolutionsCatalog::find('png-to-svg')['note'] ?? null);
        $this->assertNotEmpty(SolutionsCatalog::find('pdf-to-word')['note'] ?? null);
        $this->assertNotEmpty(SolutionsCatalog::find('background-remover')['note'] ?? null);
    }
}
