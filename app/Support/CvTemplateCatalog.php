<?php

namespace App\Support;

/**
 * 100+ CV template definitions (layout × color ways).
 */
class CvTemplateCatalog
{
    /**
     * @return array<string, array{
     *   slug:string,name:string,category:string,layout:string,
     *   accent:string,secondary:string,deep?:string,highlight?:string,
     *   gradient?:bool,description:string,sort_order:int
     * }>
     */
    public static function all(): array
    {
        $items = [];
        $order = 1;

        // Keep original flagship slugs first (stable URLs)
        foreach (self::flagship() as $row) {
            $row['sort_order'] = $order++;
            $items[$row['slug']] = $row;
        }

        $palettes = self::palettes();
        $layouts = self::layouts();

        foreach ($layouts as $layoutKey => $layout) {
            foreach ($palettes as $paletteKey => $palette) {
                $slug = $layoutKey.'-'.$paletteKey;
                if (isset($items[$slug])) {
                    continue;
                }

                $items[$slug] = [
                    'slug' => $slug,
                    'name' => $layout['label'].' · '.$palette['label'],
                    'category' => $layout['category'],
                    'layout' => $layout['layout'],
                    'accent' => $palette['accent'],
                    'secondary' => $palette['secondary'],
                    'deep' => $palette['deep'],
                    'highlight' => $palette['highlight'],
                    'gradient' => (bool) ($layout['gradient'] ?? false),
                    'description' => $layout['description'].' '.$palette['label'].' color way.',
                    'sort_order' => $order++,
                ];
            }
        }

        return $items;
    }

    public static function count(): int
    {
        return count(self::all());
    }

    private static function flagship(): array
    {
        return [
            [
                'slug' => 'nasira-modern',
                'name' => 'Nasira Modern',
                'category' => 'modern',
                'layout' => 'modern',
                'accent' => '#006837',
                'secondary' => '#F37021',
                'deep' => '#004d29',
                'highlight' => '#ffffff',
                'description' => 'Brand-forward CV with green accent bar and orange role text.',
            ],
            [
                'slug' => 'classic-serif',
                'name' => 'Classic Serif',
                'category' => 'classic',
                'layout' => 'classic',
                'accent' => '#1f2937',
                'secondary' => '#6b7280',
                'deep' => '#111827',
                'highlight' => '#ffffff',
                'description' => 'Traditional centered CV with elegant serif headings.',
            ],
            [
                'slug' => 'sidebar-pro',
                'name' => 'Sidebar Pro',
                'category' => 'sidebar',
                'layout' => 'sidebar',
                'accent' => '#0f766e',
                'secondary' => '#134e4a',
                'deep' => '#115e59',
                'highlight' => '#ffffff',
                'description' => 'Teal left rail for contact & skills; main column for experience.',
            ],
            [
                'slug' => 'executive-navy',
                'name' => 'Executive Navy',
                'category' => 'executive',
                'layout' => 'sidebar',
                'accent' => '#1e3a5f',
                'secondary' => '#c9a227',
                'deep' => '#152a45',
                'highlight' => '#c9a227',
                'description' => 'Navy sidebar executive style with gold accents.',
            ],
            [
                'slug' => 'creative-band',
                'name' => 'Creative Band',
                'category' => 'creative',
                'layout' => 'band',
                'accent' => '#ea580c',
                'secondary' => '#111827',
                'deep' => '#c2410c',
                'highlight' => '#ffffff',
                'gradient' => false,
                'description' => 'Bold top color band and expressive section titles.',
            ],
            [
                'slug' => 'minimal-air',
                'name' => 'Minimal Air',
                'category' => 'minimal',
                'layout' => 'minimal',
                'accent' => '#374151',
                'secondary' => '#9ca3af',
                'deep' => '#111827',
                'highlight' => '#ffffff',
                'description' => 'Lots of whitespace, thin rules, ATS-friendly single column.',
            ],
            [
                'slug' => 'timeline-rise',
                'name' => 'Timeline Rise',
                'category' => 'modern',
                'layout' => 'timeline',
                'accent' => '#006837',
                'secondary' => '#16a34a',
                'deep' => '#14532d',
                'highlight' => '#ffffff',
                'description' => 'Vertical timeline for experience and education.',
            ],
            [
                'slug' => 'compact-ats',
                'name' => 'Compact ATS',
                'category' => 'ats',
                'layout' => 'compact',
                'accent' => '#111827',
                'secondary' => '#4b5563',
                'deep' => '#030712',
                'highlight' => '#ffffff',
                'description' => 'Tight single-column layout optimized for ATS parsers.',
            ],
            [
                'slug' => 'gradient-hero',
                'name' => 'Gradient Hero',
                'category' => 'creative',
                'layout' => 'band',
                'accent' => '#006837',
                'secondary' => '#F37021',
                'deep' => '#004d29',
                'highlight' => '#ffffff',
                'gradient' => true,
                'description' => 'Full-width gradient header with modern body sections.',
            ],
            [
                'slug' => 'card-stack',
                'name' => 'Card Stack',
                'category' => 'modern',
                'layout' => 'cards',
                'accent' => '#0284c7',
                'secondary' => '#0369a1',
                'deep' => '#0c4a6e',
                'highlight' => '#ffffff',
                'description' => 'Section cards with soft borders for a portfolio feel.',
            ],
            [
                'slug' => 'elegant-rose',
                'name' => 'Elegant Rose',
                'category' => 'classic',
                'layout' => 'elegant',
                'accent' => '#9f1239',
                'secondary' => '#881337',
                'deep' => '#4c0519',
                'highlight' => '#ffffff',
                'description' => 'Refined serif typography with rose accents.',
            ],
            [
                'slug' => 'tech-mono',
                'name' => 'Tech Mono',
                'category' => 'modern',
                'layout' => 'tech',
                'accent' => '#065f46',
                'secondary' => '#10b981',
                'deep' => '#064e3b',
                'highlight' => '#ffffff',
                'description' => 'Monospace accents and skill chips for tech roles.',
            ],
        ];
    }

    private static function layouts(): array
    {
        return [
            'modern' => [
                'label' => 'Modern Edge',
                'layout' => 'modern',
                'category' => 'modern',
                'description' => 'Accent bar + clean single column.',
            ],
            'classic' => [
                'label' => 'Classic Center',
                'layout' => 'classic',
                'category' => 'classic',
                'description' => 'Centered serif professional resume.',
            ],
            'sidebar' => [
                'label' => 'Sidebar Split',
                'layout' => 'sidebar',
                'category' => 'sidebar',
                'description' => 'Two-column sidebar + main layout.',
            ],
            'executive' => [
                'label' => 'Executive Rail',
                'layout' => 'sidebar',
                'category' => 'executive',
                'description' => 'Executive two-column with strong sidebar.',
            ],
            'band' => [
                'label' => 'Header Band',
                'layout' => 'band',
                'category' => 'creative',
                'gradient' => false,
                'description' => 'Solid header band resume.',
            ],
            'gradient' => [
                'label' => 'Gradient Header',
                'layout' => 'band',
                'category' => 'creative',
                'gradient' => true,
                'description' => 'Gradient hero header resume.',
            ],
            'minimal' => [
                'label' => 'Minimal Clean',
                'layout' => 'minimal',
                'category' => 'minimal',
                'description' => 'Airy minimal single column.',
            ],
            'timeline' => [
                'label' => 'Timeline',
                'layout' => 'timeline',
                'category' => 'modern',
                'description' => 'Career timeline markers.',
            ],
            'compact' => [
                'label' => 'Compact ATS',
                'layout' => 'compact',
                'category' => 'ats',
                'description' => 'Dense ATS-friendly layout.',
            ],
            'cards' => [
                'label' => 'Card Stack',
                'layout' => 'cards',
                'category' => 'modern',
                'description' => 'Soft card sections.',
            ],
            'elegant' => [
                'label' => 'Elegant Serif',
                'layout' => 'elegant',
                'category' => 'classic',
                'description' => 'Elegant ornamental serif style.',
            ],
            'tech' => [
                'label' => 'Tech Stack',
                'layout' => 'tech',
                'category' => 'modern',
                'description' => 'Developer-style sidebar resume.',
            ],
        ];
    }

    private static function palettes(): array
    {
        return [
            'nasira' => ['label' => 'Nasira', 'accent' => '#006837', 'secondary' => '#F37021', 'deep' => '#004d29', 'highlight' => '#ffffff'],
            'teal' => ['label' => 'Teal', 'accent' => '#0f766e', 'secondary' => '#14b8a6', 'deep' => '#115e59', 'highlight' => '#ffffff'],
            'navy' => ['label' => 'Navy', 'accent' => '#1e3a5f', 'secondary' => '#c9a227', 'deep' => '#152a45', 'highlight' => '#c9a227'],
            'indigo' => ['label' => 'Indigo', 'accent' => '#3730a3', 'secondary' => '#818cf8', 'deep' => '#312e81', 'highlight' => '#ffffff'],
            'sky' => ['label' => 'Sky', 'accent' => '#0284c7', 'secondary' => '#38bdf8', 'deep' => '#075985', 'highlight' => '#ffffff'],
            'rose' => ['label' => 'Rose', 'accent' => '#be123c', 'secondary' => '#fb7185', 'deep' => '#9f1239', 'highlight' => '#ffffff'],
            'amber' => ['label' => 'Amber', 'accent' => '#d97706', 'secondary' => '#f59e0b', 'deep' => '#92400e', 'highlight' => '#ffffff'],
            'violet' => ['label' => 'Violet', 'accent' => '#7c3aed', 'secondary' => '#a78bfa', 'deep' => '#5b21b6', 'highlight' => '#ffffff'],
            'emerald' => ['label' => 'Emerald', 'accent' => '#059669', 'secondary' => '#34d399', 'deep' => '#065f46', 'highlight' => '#ffffff'],
            'slate' => ['label' => 'Slate', 'accent' => '#334155', 'secondary' => '#94a3b8', 'deep' => '#1e293b', 'highlight' => '#ffffff'],
            'crimson' => ['label' => 'Crimson', 'accent' => '#b91c1c', 'secondary' => '#f87171', 'deep' => '#7f1d1d', 'highlight' => '#ffffff'],
            'forest' => ['label' => 'Forest', 'accent' => '#166534', 'secondary' => '#86efac', 'deep' => '#14532d', 'highlight' => '#ffffff'],
            'copper' => ['label' => 'Copper', 'accent' => '#c2410c', 'secondary' => '#fdba74', 'deep' => '#9a3412', 'highlight' => '#ffffff'],
            'graphite' => ['label' => 'Graphite', 'accent' => '#111827', 'secondary' => '#6b7280', 'deep' => '#030712', 'highlight' => '#ffffff'],
            'ocean' => ['label' => 'Ocean', 'accent' => '#0369a1', 'secondary' => '#7dd3fc', 'deep' => '#0c4a6e', 'highlight' => '#ffffff'],
            'plum' => ['label' => 'Plum', 'accent' => '#86198f', 'secondary' => '#e879f9', 'deep' => '#701a75', 'highlight' => '#ffffff'],
            'mint' => ['label' => 'Mint', 'accent' => '#0d9488', 'secondary' => '#5eead4', 'deep' => '#0f766e', 'highlight' => '#ffffff'],
            'charcoal' => ['label' => 'Charcoal', 'accent' => '#3f3f46', 'secondary' => '#a1a1aa', 'deep' => '#27272a', 'highlight' => '#ffffff'],
        ];
    }
}
