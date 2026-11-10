<?php

namespace Database\Seeders;

use App\Models\CvTemplate;
use App\Support\CvCanvasTemplates;
use App\Support\CvTemplateCatalog;
use Illuminate\Database\Seeder;

class CvTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = CvTemplateCatalog::all();

        foreach ($catalog as $meta) {
            $canvas = CvCanvasTemplates::build($meta);

            CvTemplate::updateOrCreate(
                ['slug' => $meta['slug']],
                [
                    'name' => $meta['name'],
                    'category' => $meta['category'],
                    'accent_color' => $meta['accent'],
                    'secondary_color' => $meta['secondary'],
                    'layout' => $meta['layout'],
                    'description' => $meta['description'],
                    'sort_order' => $meta['sort_order'],
                    'is_active' => true,
                    'is_premium' => false,
                    'html' => $canvas['html'],
                    'css' => $canvas['css'],
                    'project_json' => null,
                ]
            );
        }

        // Deactivate old templates that are no longer in the catalog
        CvTemplate::whereNotIn('slug', array_keys($catalog))->update(['is_active' => false]);
    }
}
