<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Available fonts
    |--------------------------------------------------------------------------
    */
    'fonts' => [
        'Plus Jakarta Sans' => [
            'label' => 'Plus Jakarta Sans',
            'family' => "'Plus Jakarta Sans', 'Poppins', ui-sans-serif, system-ui, sans-serif",
            'import' => 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap',
        ],
        'Outfit' => [
            'label' => 'Outfit',
            'family' => "'Outfit', ui-sans-serif, system-ui, sans-serif",
            'import' => 'https://fonts.bunny.net/css?family=outfit:400,500,600,700&display=swap',
        ],
        'Fraunces' => [
            'label' => 'Fraunces',
            'family' => "'Fraunces', ui-serif, Georgia, serif",
            'import' => 'https://fonts.bunny.net/css?family=fraunces:500,600,700&display=swap',
        ],
        'Geist' => [
            'label' => 'Geist',
            'family' => "'Geist', ui-sans-serif, system-ui, sans-serif",
            'import' => 'https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap',
        ],
        'Inter' => [
            'label' => 'Inter',
            'family' => "'Inter', ui-sans-serif, system-ui, sans-serif",
            'import' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        ],
        'Figtree' => [
            'label' => 'Figtree',
            'family' => "'Figtree', ui-sans-serif, system-ui, sans-serif",
            'import' => 'https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap',
        ],
        'IBM Plex Sans' => [
            'label' => 'IBM Plex Sans',
            'family' => "'IBM Plex Sans', ui-sans-serif, system-ui, sans-serif",
            'import' => 'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap',
        ],
        'System' => [
            'label' => 'System UI',
            'family' => 'ui-sans-serif, system-ui, sans-serif',
            'import' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Token groups for the Appearance admin UI
    |--------------------------------------------------------------------------
    */
    'groups' => [
        'brand' => [
            'label' => 'Brand',
            'description' => 'Primary project colors used by buttons, focus rings, and page surfaces.',
            'sections' => [
                [
                    'label' => 'Primary',
                    'tokens' => ['primary', 'primary-foreground'],
                ],
                [
                    'label' => 'Secondary',
                    'tokens' => ['secondary', 'secondary-foreground'],
                ],
                [
                    'label' => 'Accent',
                    'tokens' => ['accent', 'accent-foreground'],
                ],
                [
                    'label' => 'Surfaces',
                    'tokens' => ['background', 'foreground'],
                ],
                [
                    'label' => 'Muted',
                    'tokens' => ['muted', 'muted-foreground'],
                ],
                [
                    'label' => 'Chrome',
                    'tokens' => ['border', 'ring'],
                ],
            ],
        ],
        'sidebar' => [
            'label' => 'Sidebar',
            'description' => 'Sidebar background, text, active/hover states, border, and focus ring.',
            'sections' => [
                [
                    'label' => 'Base',
                    'tokens' => [
                        'sidebar',
                        'sidebar-foreground',
                        'sidebar-primary',
                        'sidebar-primary-foreground',
                    ],
                ],
                [
                    'label' => 'Hover',
                    'tokens' => ['sidebar-accent', 'sidebar-accent-foreground'],
                ],
                [
                    'label' => 'Active',
                    'tokens' => ['sidebar-active', 'sidebar-active-foreground'],
                ],
                [
                    'label' => 'Border & focus',
                    'tokens' => ['sidebar-border', 'sidebar-ring'],
                ],
            ],
        ],
        'topbar' => [
            'label' => 'Top bar',
            'description' => 'Dashboard header/top bar colors.',
            'sections' => [
                [
                    'label' => 'Colors',
                    'tokens' => ['topbar', 'topbar-foreground'],
                ],
                [
                    'label' => 'Border',
                    'tokens' => ['topbar-border'],
                ],
            ],
        ],
        'typography' => [
            'label' => 'Type',
            'description' => 'Font family and pixel sizes for headings, body, breadcrumbs, links, and small text.',
            'tokens' => [
                'font-sans',
                'font-size',
                'font-size-h1',
                'font-size-h2',
                'font-size-h3',
                'font-size-p',
                'font-size-small',
                'font-size-breadcrumb',
                'font-size-link',
                'font-size-label',
            ],
        ],
    ],

    'token_meta' => [
        'primary' => ['label' => 'Primary', 'type' => 'color'],
        'primary-foreground' => ['label' => 'Primary foreground', 'type' => 'color'],
        'secondary' => ['label' => 'Secondary', 'type' => 'color'],
        'secondary-foreground' => ['label' => 'Secondary foreground', 'type' => 'color'],
        'accent' => ['label' => 'Accent', 'type' => 'color'],
        'accent-foreground' => ['label' => 'Accent foreground', 'type' => 'color'],
        'background' => ['label' => 'Background', 'type' => 'color'],
        'foreground' => ['label' => 'Foreground', 'type' => 'color'],
        'muted' => ['label' => 'Muted', 'type' => 'color'],
        'muted-foreground' => ['label' => 'Muted foreground', 'type' => 'color'],
        'border' => ['label' => 'Border', 'type' => 'color'],
        'ring' => ['label' => 'Ring', 'type' => 'color'],
        'sidebar' => ['label' => 'Sidebar background', 'type' => 'color'],
        'sidebar-foreground' => ['label' => 'Sidebar text', 'type' => 'color'],
        'sidebar-primary' => ['label' => 'Sidebar primary / brand tile', 'type' => 'color'],
        'sidebar-primary-foreground' => ['label' => 'Sidebar primary text', 'type' => 'color'],
        'sidebar-accent' => ['label' => 'Sidebar hover', 'type' => 'color'],
        'sidebar-accent-foreground' => ['label' => 'Sidebar hover text', 'type' => 'color'],
        'sidebar-active' => ['label' => 'Sidebar active', 'type' => 'color'],
        'sidebar-active-foreground' => ['label' => 'Sidebar active text', 'type' => 'color'],
        'sidebar-border' => ['label' => 'Sidebar border', 'type' => 'color'],
        'sidebar-ring' => ['label' => 'Sidebar focus ring', 'type' => 'color'],
        'topbar' => ['label' => 'Top bar background', 'type' => 'color'],
        'topbar-foreground' => ['label' => 'Top bar text', 'type' => 'color'],
        'topbar-border' => ['label' => 'Top bar border', 'type' => 'color'],
        'font-sans' => ['label' => 'Font family', 'type' => 'font'],
        'font-size' => ['label' => 'Base / body', 'type' => 'px', 'min' => 10, 'max' => 24, 'hint' => 'Root html font size'],
        'font-size-h1' => ['label' => 'Heading 1', 'type' => 'px', 'min' => 16, 'max' => 48, 'hint' => 'Page titles'],
        'font-size-h2' => ['label' => 'Heading 2', 'type' => 'px', 'min' => 14, 'max' => 36, 'hint' => 'Section titles'],
        'font-size-h3' => ['label' => 'Heading 3', 'type' => 'px', 'min' => 12, 'max' => 28, 'hint' => 'Card / subsection titles'],
        'font-size-p' => ['label' => 'Paragraph', 'type' => 'px', 'min' => 10, 'max' => 24, 'hint' => 'Descriptions under titles'],
        'font-size-small' => ['label' => 'Small / caption', 'type' => 'px', 'min' => 10, 'max' => 18, 'hint' => 'Helper and meta text'],
        'font-size-breadcrumb' => ['label' => 'Breadcrumb', 'type' => 'px', 'min' => 10, 'max' => 20, 'hint' => 'Top bar breadcrumb'],
        'font-size-link' => ['label' => 'Link', 'type' => 'px', 'min' => 10, 'max' => 24, 'hint' => 'Inline and nav links'],
        'font-size-label' => ['label' => 'Form label', 'type' => 'px', 'min' => 10, 'max' => 20, 'hint' => 'Input labels'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default light tokens — Nasira Jobs brand
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'primary' => '#006837',
        'primary-foreground' => '#ffffff',
        'secondary' => '#eef6f1',
        'secondary-foreground' => '#1e2b24',
        'accent' => '#f37021',
        'accent-foreground' => '#ffffff',
        'background' => '#ffffff',
        'foreground' => '#1e2b24',
        'muted' => '#f3f6f4',
        'muted-foreground' => '#5f6e66',
        'border' => '#d9e3dd',
        'ring' => '#006837',
        'sidebar' => '#f7faf8',
        'sidebar-foreground' => '#1e2b24',
        'sidebar-primary' => '#006837',
        'sidebar-primary-foreground' => '#ffffff',
        'sidebar-accent' => '#eef6f1',
        'sidebar-accent-foreground' => '#1e2b24',
        'sidebar-active' => '#d9efe3',
        'sidebar-active-foreground' => '#006837',
        'sidebar-border' => '#d9e3dd',
        'sidebar-ring' => '#006837',
        'topbar' => '#ffffff',
        'topbar-foreground' => '#1e2b24',
        'topbar-border' => '#d9e3dd',
        'font-sans' => 'Plus Jakarta Sans',
        'font-size' => '16px',
        'font-size-h1' => '32px',
        'font-size-h2' => '24px',
        'font-size-h3' => '18px',
        'font-size-p' => '15px',
        'font-size-small' => '13px',
        'font-size-breadcrumb' => '14px',
        'font-size-link' => '14px',
        'font-size-label' => '14px',
    ],
];
