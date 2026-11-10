<?php

namespace App\Support;

/**
 * Canva-style A4 resume starters with clear selectable sections
 * (Page / Sidebar / Main / Header / Card).
 */
class CvCanvasTemplates
{
    public static function all(): array
    {
        $out = [];
        foreach (CvTemplateCatalog::all() as $slug => $meta) {
            $out[$slug] = self::build($meta);
        }

        return $out;
    }

    public static function forSlug(string $slug): array
    {
        $meta = CvTemplateCatalog::all()[$slug] ?? null;

        return $meta ? self::build($meta) : self::modern();
    }

    /**
     * @param  array<string, mixed>  $meta
     * @return array{html:string,css:string}
     */
    public static function build(array $meta): array
    {
        $accent = $meta['accent'] ?? '#006837';
        $secondary = $meta['secondary'] ?? '#F37021';
        $deep = $meta['deep'] ?? $accent;
        $highlight = $meta['highlight'] ?? '#ffffff';
        $gradient = (bool) ($meta['gradient'] ?? false);

        return match ($meta['layout'] ?? 'modern') {
            'classic' => self::classic($accent, $secondary),
            'sidebar' => self::sidebar($accent, $deep, $highlight),
            'band' => self::band($accent, $secondary, $gradient),
            'minimal' => self::minimal($accent, $secondary),
            'timeline' => self::timeline($accent, $secondary),
            'compact' => self::compact($accent, $secondary),
            'cards' => self::cards($accent, $secondary),
            'elegant' => self::elegant($accent, $secondary),
            'tech' => self::tech($accent, $secondary),
            default => self::modern($accent, $secondary),
        };
    }

    private static function person(): array
    {
        return [
            'name' => 'Alex Johnson',
            'role' => 'Senior Product Designer',
            'email' => 'alex.johnson@email.com',
            'phone' => '+251 911 234 567',
            'location' => 'Addis Ababa, Ethiopia',
            'web' => 'alexjohnson.design',
            'summary' => 'Product designer with 6+ years crafting clear, conversion-focused experiences for hiring, fintech, and SaaS products. Known for systems thinking, stakeholder alignment, and shipping polished interfaces that teams can scale.',
            'initials' => 'AJ',
        ];
    }

    private static function fonts(): string
    {
        return "@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&family=Libre+Baskerville:wght@400;700&display=swap');";
    }

    /** Shared selectable region attributes */
    private static function region(string $name): string
    {
        return 'data-gjs-name="'.$name.'" data-gjs-highlightable="true" data-gjs-selectable="true" data-gjs-hoverable="true" data-gjs-droppable="true"';
    }

    /** Wrapper rows must NOT steal hover/selection from Sidebar / Main */
    private static function layoutShell(): string
    {
        return 'class="cv-layout" data-gjs-name="Layout" data-gjs-selectable="false" data-gjs-hoverable="false" data-gjs-highlightable="false" data-gjs-layerable="false"';
    }

    private static function text(): string
    {
        return 'data-gjs-type="text" data-gjs-name="Text" data-gjs-selectable="true"';
    }

    private static function placeholderAvatar(string $initials = 'AJ'): string
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" viewBox="0 0 192 192">'
            .'<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#F37021"/><stop offset="1" stop-color="#006837"/></linearGradient></defs>'
            .'<rect width="192" height="192" fill="url(#g)"/>'
            .'<text x="96" y="110" text-anchor="middle" fill="#fff" font-family="Arial,sans-serif" font-size="64" font-weight="700">'.$initials.'</text>'
            .'</svg>';

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    private static function base(string $accent, string $secondary, string $font): string
    {
        return self::fonts().<<<CSS
.cv-page{box-sizing:border-box;width:794px;max-width:794px;height:1123px;min-height:1123px;max-height:1123px;margin:0 auto;background:#fff;color:#1f2937;font-family:{$font};position:relative;overflow:hidden;}
.cv-page *,.cv-page *::before,.cv-page *::after{box-sizing:border-box;max-width:100%;}
.cv-h2{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:{$accent};border-bottom:2px solid {$accent};padding:0 0 8px;margin:0 0 14px;font-weight:700;}
.cv-name{font-size:38px;line-height:1.05;margin:0 0 6px;font-weight:700;color:{$accent};letter-spacing:-0.02em;overflow-wrap:anywhere;}
.cv-role{font-size:14px;margin:0 0 10px;font-weight:700;color:{$secondary};overflow-wrap:anywhere;}
.cv-contact{font-size:11.5px;color:#4b5563;margin:0;line-height:1.55;overflow-wrap:anywhere;}
.cv-p{font-size:12.5px;line-height:1.6;margin:0;color:#374151;overflow-wrap:anywhere;}
.cv-section{margin:0 0 18px;overflow:hidden;}
.cv-item{margin:0 0 14px;}
.cv-item-title{font-size:13.5px;font-weight:700;margin:0;color:#111827;}
.cv-item-meta{font-size:11.5px;color:#6b7280;margin:3px 0 6px;font-weight:600;}
.cv-item-head{display:flex;justify-content:space-between;gap:12px;align-items:flex-start;}
.cv-dates{font-size:11px;color:{$accent};font-weight:700;white-space:nowrap;}
.cv-chip{display:inline-block;background:rgba(0,0,0,.045);color:{$accent};border:1px solid rgba(0,0,0,.07);border-radius:999px;padding:5px 12px;font-size:11px;font-weight:700;margin:0 6px 7px 0;}
.cv-bullet{margin:0;padding-left:16px;font-size:12.5px;line-height:1.55;color:#374151;}
.cv-bullet li{margin:0 0 4px;overflow-wrap:anywhere;}
.cv-avatar,.cv-avatar img{width:96px;height:96px;border-radius:50%;object-fit:cover;object-position:center;display:block;overflow:hidden;flex-shrink:0;}
.cv-avatar{margin:0 auto 16px;background:#d1d5db;}
.cv-layout{display:flex;align-items:stretch;height:1123px;min-height:1123px;width:100%;max-width:100%;}
.cv-side{flex:0 0 34%;width:34%;padding:32px 20px;overflow:hidden;height:100%;min-height:100%;box-sizing:border-box;}
.cv-main{flex:1 1 0;min-width:0;width:auto;padding:32px 26px;overflow:hidden;height:100%;min-height:100%;box-sizing:border-box;}
.cv-band{padding:36px 36px 30px;overflow:hidden;}
.cv-body{padding:26px 36px 32px;overflow:hidden;}
.cv-card{background:#fff;border:1px solid #dbeafe;border-radius:14px;padding:18px 20px;margin:0 0 12px;box-shadow:0 10px 24px rgba(3,105,161,.07);overflow:hidden;}
CSS;
    }

    private static function experienceHtml(): string
    {
        $t = self::text();

        return <<<HTML
<div class="cv-item" data-gjs-name="Experience item" data-gjs-selectable="true">
  <div class="cv-item-head">
    <div>
      <div {$t} class="cv-item-title">Senior Product Designer</div>
      <div {$t} class="cv-item-meta">Nasira Labs · Full-time</div>
    </div>
    <div {$t} class="cv-dates">2023 – Present</div>
  </div>
  <ul class="cv-bullet">
    <li {$t}>Led end-to-end redesign of candidate apply flow; +28% completed applications.</li>
    <li {$t}>Built a shared design system adopted by 3 product squads.</li>
    <li {$t}>Partnered with research to validate hiring manager dashboards.</li>
  </ul>
</div>
<div class="cv-item" data-gjs-name="Experience item" data-gjs-selectable="true">
  <div class="cv-item-head">
    <div>
      <div {$t} class="cv-item-title">Product Designer</div>
      <div {$t} class="cv-item-meta">Horizon Digital · Contract</div>
    </div>
    <div {$t} class="cv-dates">2020 – 2023</div>
  </div>
  <ul class="cv-bullet">
    <li {$t}>Designed mobile wallet and merchant onboarding for East African fintech clients.</li>
    <li {$t}>Improved first-time activation by 19% through clearer empty states and guidance.</li>
  </ul>
</div>
<div class="cv-item" data-gjs-name="Experience item" data-gjs-selectable="true">
  <div class="cv-item-head">
    <div>
      <div {$t} class="cv-item-title">UI Designer</div>
      <div {$t} class="cv-item-meta">BrightPath Studio</div>
    </div>
    <div {$t} class="cv-dates">2018 – 2020</div>
  </div>
  <ul class="cv-bullet">
    <li {$t}>Shipped marketing sites and product UI for education and logistics startups.</li>
  </ul>
</div>
HTML;
    }

    private static function educationHtml(): string
    {
        $t = self::text();

        return <<<HTML
<div class="cv-item" data-gjs-name="Education item" data-gjs-selectable="true">
  <div class="cv-item-head">
    <div>
      <div {$t} class="cv-item-title">BSc Computer Science</div>
      <div {$t} class="cv-item-meta">Addis Ababa University · GPA 3.6</div>
    </div>
    <div {$t} class="cv-dates">2019</div>
  </div>
</div>
<div class="cv-item" data-gjs-name="Education item" data-gjs-selectable="true">
  <div class="cv-item-head">
    <div>
      <div {$t} class="cv-item-title">UX Certificate</div>
      <div {$t} class="cv-item-meta">Google UX Design Professional Certificate</div>
    </div>
    <div {$t} class="cv-dates">2021</div>
  </div>
</div>
HTML;
    }

    private static function skillsHtml(): string
    {
        $t = self::text();

        return <<<HTML
<span {$t} class="cv-chip">Product Design</span><span {$t} class="cv-chip">Figma</span><span {$t} class="cv-chip">Design Systems</span>
<span {$t} class="cv-chip">User Research</span><span {$t} class="cv-chip">Prototyping</span><span {$t} class="cv-chip">HTML/CSS</span>
<span {$t} class="cv-chip">Workshop Facilitation</span>
HTML;
    }

    private static function section(string $title, string $body): string
    {
        $t = self::text();
        $r = self::region($title);

        return '<div class="cv-section" '.$r.'><div '.$t.' class="cv-h2">'.$title.'</div>'.$body.'</div>';
    }

    private static function modern(string $accent = '#006837', string $secondary = '#F37021'): array
    {
        $p = self::person();
        $t = self::text();
        $css = self::base($accent, $secondary, "'DM Sans',Arial,sans-serif")
            .'.cv-page{padding:0;}'
            .'.cv-accent{width:10px;height:100%;background:linear-gradient(180deg,'.$accent.','.$secondary.');flex:0 0 10px;}'
            .'.cv-inner{flex:1;padding:34px 36px 28px 32px;}'
            .'.cv-top{margin:0 0 20px;padding:0 0 16px;border-bottom:1px solid #e5e7eb;}'
            .'.cv-layout{display:flex;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div '.self::layoutShell().'>'
            .'<div class="cv-accent" '.self::region('Accent bar').'></div>'
            .'<div class="cv-inner" '.self::region('Main content').'>'
            .'<div class="cv-top" '.self::region('Header').'>'
            .'<div '.$t.' class="cv-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-role">'.$p['role'].'</div>'
            .'<div '.$t.' class="cv-contact">'.$p['email'].'  ·  '.$p['phone'].'  ·  '.$p['location'].'  ·  '.$p['web'].'</div>'
            .'</div>'
            .self::section('Professional Summary', '<div '.$t.' class="cv-p">'.$p['summary'].'</div>')
            .self::section('Experience', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .self::section('Skills', '<div>'.self::skillsHtml().'</div>')
            .'</div></div></div>';

        return compact('html', 'css');
    }

    private static function classic(string $accent = '#1f2937', string $secondary = '#6b7280'): array
    {
        $p = self::person();
        $t = self::text();
        $css = self::base($accent, $secondary, "Libre Baskerville,Georgia,serif")
            .'.cv-page{padding:40px 46px;}'
            .'.cv-name{font-family:Libre Baskerville,Georgia,serif;font-size:42px;font-weight:700;text-align:center;color:'.$accent.';}'
            .'.cv-role,.cv-contact{text-align:center;font-family:DM Sans,Arial,sans-serif;}'
            .'.cv-h2{text-align:center;border-bottom-width:1px;letter-spacing:2.8px;font-family:DM Sans,Arial,sans-serif;}'
            .'.cv-p,.cv-item-title,.cv-item-meta,.cv-bullet,.cv-chip,.cv-dates{font-family:DM Sans,Arial,sans-serif;}'
            .'.cv-rule{height:1px;background:#d1d5db;margin:18px 0 22px;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div '.self::region('Header').'>'
            .'<div '.$t.' class="cv-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-role">'.$p['role'].'</div>'
            .'<div '.$t.' class="cv-contact">'.$p['email'].' · '.$p['phone'].' · '.$p['location'].'</div>'
            .'<div class="cv-rule"></div></div>'
            .self::section('Summary', '<div '.$t.' class="cv-p" style="text-align:center;">'.$p['summary'].'</div>')
            .self::section('Experience', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .self::section('Skills', '<div style="text-align:center;">'.self::skillsHtml().'</div>')
            .'</div>';

        return compact('html', 'css');
    }

    private static function elegant(string $accent = '#9f1239', string $secondary = '#881337'): array
    {
        $p = self::person();
        $t = self::text();
        $css = self::base($accent, $secondary, "'Cormorant Garamond',Georgia,serif")
            .'.cv-page{padding:38px 42px;}'
            .'.cv-name{font-family:Cormorant Garamond,Georgia,serif;font-size:48px;font-weight:600;text-align:center;}'
            .'.cv-role,.cv-contact,.cv-p,.cv-item-title,.cv-item-meta,.cv-bullet,.cv-h2,.cv-chip,.cv-dates{font-family:DM Sans,Arial,sans-serif;}'
            .'.cv-role,.cv-contact{text-align:center;}'
            .'.cv-h2{text-align:center;letter-spacing:3px;border-bottom-width:1px;}'
            .'.cv-ornament{width:72px;height:2px;background:'.$accent.';margin:16px auto 0;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div '.self::region('Header').'>'
            .'<div '.$t.' class="cv-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-role">'.$p['role'].'</div>'
            .'<div '.$t.' class="cv-contact">'.$p['email'].' · '.$p['phone'].' · '.$p['location'].'</div>'
            .'<div class="cv-ornament"></div></div>'
            .self::section('Profile', '<div '.$t.' class="cv-p">'.$p['summary'].'</div>')
            .self::section('Experience', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .self::section('Expertise', '<div>'.self::skillsHtml().'</div>')
            .'</div>';

        return compact('html', 'css');
    }

    private static function sidebar(string $accent, string $deep, string $highlight): array
    {
        $p = self::person();
        $t = self::text();
        $nameColor = $highlight === '#ffffff' ? '#ffffff' : $highlight;
        $css = self::base($accent, $highlight === '#ffffff' ? $accent : $highlight, "'DM Sans',Arial,sans-serif")
            .'.cv-page{padding:0;}'
            .'.cv-side{background:linear-gradient(180deg,'.$accent.' 0%,'.$deep.' 100%);color:#fff;}'
            .'.cv-side .cv-h2{color:#fff;border-bottom-color:rgba(255,255,255,.32);}'
            .'.cv-side .cv-contact,.cv-side .cv-p{color:rgba(255,255,255,.92);}'
            .'.cv-side .cv-chip{background:rgba(255,255,255,.14);color:#fff;border-color:rgba(255,255,255,.22);}'
            .'.cv-avatar{border:3px solid rgba(255,255,255,.28);margin:0 auto 16px;background:rgba(255,255,255,.16);}'
            .'.cv-main .cv-name{font-size:30px;margin-bottom:4px;color:'.$accent.';}'
            .'.cv-side-name{font-size:20px;font-weight:700;text-align:center;line-height:1.2;color:'.$nameColor.';}'
            .'.cv-side-role{font-size:12px;text-align:center;opacity:.92;margin:6px 0 18px;font-weight:600;}';

        $photo = self::placeholderAvatar($p['initials']);
        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div '.self::layoutShell().'>'
            .'<aside class="cv-side" '.self::region('Sidebar').'>'
            .'<img class="cv-avatar" src="'.$photo.'" alt="Profile photo" data-gjs-type="image" data-gjs-name="Profile photo" data-gjs-selectable="true" />'
            .'<div '.$t.' class="cv-side-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-side-role">'.$p['role'].'</div>'
            .self::section('Contact', '<div '.$t.' class="cv-contact">'.$p['email'].'<br>'.$p['phone'].'<br>'.$p['location'].'<br>'.$p['web'].'</div>')
            .self::section('Skills', '<div>'.self::skillsHtml().'</div>')
            .self::section('Languages', '<div><span '.$t.' class="cv-chip">English</span><span '.$t.' class="cv-chip">Amharic</span><span '.$t.' class="cv-chip">French</span></div>')
            .'</aside>'
            .'<main class="cv-main" '.self::region('Main').'>'
            .self::section('Profile', '<div '.$t.' class="cv-p">'.$p['summary'].'</div>')
            .self::section('Experience', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .'</main>'
            .'</div></div>';

        return compact('html', 'css');
    }

    private static function band(string $a, string $s, bool $gradient): array
    {
        $p = self::person();
        $t = self::text();
        $bg = $gradient ? "linear-gradient(125deg,{$a} 0%,{$s} 100%)" : $a;
        $css = self::base($a, $s, "'DM Sans',Arial,sans-serif")
            .'.cv-page{padding:0;}'
            .'.cv-band{background:'.$bg.';color:#fff;}'
            .'.cv-band .cv-name,.cv-band .cv-role,.cv-band .cv-contact{color:#fff;}'
            .'.cv-band .cv-name{font-size:40px;}'
            .'.cv-band .cv-role{opacity:.95;}'
            .'.cv-band .cv-contact{opacity:.9;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div class="cv-band" '.self::region('Header').'>'
            .'<div '.$t.' class="cv-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-role">'.$p['role'].'</div>'
            .'<div '.$t.' class="cv-contact">'.$p['email'].'  ·  '.$p['phone'].'  ·  '.$p['location'].'</div>'
            .'</div>'
            .'<div class="cv-body" '.self::region('Main').'>'
            .self::section('About', '<div '.$t.' class="cv-p">'.$p['summary'].'</div>')
            .self::section('Experience', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .self::section('Skills', '<div>'.self::skillsHtml().'</div>')
            .'</div></div>';

        return compact('html', 'css');
    }

    private static function minimal(string $accent = '#111827', string $secondary = '#6b7280'): array
    {
        $p = self::person();
        $t = self::text();
        $css = self::base($accent, $secondary, "'DM Sans',Arial,sans-serif")
            .'.cv-page{padding:44px 48px;}'
            .'.cv-name{color:'.$accent.';font-weight:600;font-size:34px;}'
            .'.cv-role{color:'.$secondary.';font-weight:600;}'
            .'.cv-h2{border:0;color:#9ca3af;letter-spacing:2.6px;padding-bottom:0;margin-bottom:10px;}'
            .'.cv-chip{border-radius:6px;background:#f3f4f6;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div '.self::region('Header').' style="margin-bottom:30px;">'
            .'<div '.$t.' class="cv-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-role">'.$p['role'].'</div>'
            .'<div '.$t.' class="cv-contact">'.$p['email'].' · '.$p['phone'].' · '.$p['location'].'</div></div>'
            .self::section('Summary', '<div '.$t.' class="cv-p">'.$p['summary'].'</div>')
            .self::section('Experience', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .self::section('Skills', '<div>'.self::skillsHtml().'</div>')
            .'</div>';

        return compact('html', 'css');
    }

    private static function timeline(string $accent = '#006837', string $secondary = '#16a34a'): array
    {
        $p = self::person();
        $t = self::text();
        $css = self::base($accent, $secondary, "'DM Sans',Arial,sans-serif")
            .'.cv-page{padding:32px 36px;}'
            .'.cv-item{border-left:3px solid '.$accent.';padding:0 0 4px 18px;position:relative;margin-bottom:16px;}'
            .'.cv-item:before{content:"";width:11px;height:11px;border-radius:50%;background:'.$accent.';position:absolute;left:-7px;top:4px;box-shadow:0 0 0 3px #fff,0 0 0 5px '.$accent.'33;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div '.self::region('Header').' style="margin-bottom:22px;">'
            .'<div '.$t.' class="cv-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-role">'.$p['role'].'</div>'
            .'<div '.$t.' class="cv-contact">'.$p['email'].' · '.$p['phone'].' · '.$p['location'].'</div></div>'
            .self::section('Summary', '<div '.$t.' class="cv-p">'.$p['summary'].'</div>')
            .self::section('Career Timeline', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .self::section('Skills', '<div>'.self::skillsHtml().'</div>')
            .'</div>';

        return compact('html', 'css');
    }

    private static function compact(string $accent = '#111827', string $secondary = '#4b5563'): array
    {
        $p = self::person();
        $t = self::text();
        $css = self::base($accent, $secondary, 'Arial,Helvetica,sans-serif')
            .'.cv-page{padding:20px 22px;}'
            .'.cv-name{font-size:22px;}'
            .'.cv-role{font-size:12px;margin-bottom:4px;}'
            .'.cv-contact,.cv-p,.cv-item-meta,.cv-bullet{font-size:11px;line-height:1.45;}'
            .'.cv-h2{font-size:10px;margin-bottom:6px;padding-bottom:4px;}'
            .'.cv-item{margin-bottom:8px;}'
            .'.cv-item-title{font-size:12px;}'
            .'.cv-chip{padding:3px 8px;font-size:10px;border-radius:3px;margin:0 4px 5px 0;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div '.self::region('Header').' style="margin-bottom:10px;padding-bottom:8px;border-bottom:1.5px solid '.$accent.';">'
            .'<div '.$t.' class="cv-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-role">'.$p['role'].'</div>'
            .'<div '.$t.' class="cv-contact">'.$p['email'].' | '.$p['phone'].' | '.$p['location'].' | '.$p['web'].'</div></div>'
            .self::section('Summary', '<div '.$t.' class="cv-p">'.$p['summary'].'</div>')
            .self::section('Experience', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .self::section('Skills', '<div>'.self::skillsHtml().'</div>')
            .'</div>';

        return compact('html', 'css');
    }

    private static function cards(string $accent = '#0284c7', string $secondary = '#0369a1'): array
    {
        $p = self::person();
        $t = self::text();
        $css = self::base($accent, $secondary, "'DM Sans',Arial,sans-serif")
            .'.cv-page{padding:22px;background:#f8fafc;}'
            .'.cv-card .cv-h2{margin-bottom:10px;}'
            .'.cv-name{font-size:34px;}'
            .'.cv-card{border-color:'.$accent.'33;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div class="cv-card" '.self::region('Header card').'>'
            .'<div '.$t.' class="cv-name">'.$p['name'].'</div>'
            .'<div '.$t.' class="cv-role">'.$p['role'].'</div>'
            .'<div '.$t.' class="cv-contact">'.$p['email'].' · '.$p['phone'].' · '.$p['location'].'</div></div>'
            .'<div class="cv-card" '.self::region('About card').'><div '.$t.' class="cv-h2">About</div><div '.$t.' class="cv-p">'.$p['summary'].'</div></div>'
            .'<div class="cv-card" '.self::region('Experience card').'><div '.$t.' class="cv-h2">Experience</div>'.self::experienceHtml().'</div>'
            .'<div class="cv-card" '.self::region('Education card').'><div '.$t.' class="cv-h2">Education</div>'.self::educationHtml().'</div>'
            .'<div class="cv-card" '.self::region('Skills card').'><div '.$t.' class="cv-h2">Skills</div><div>'.self::skillsHtml().'</div></div>'
            .'</div>';

        return compact('html', 'css');
    }

    private static function tech(string $accent = '#065f46', string $secondary = '#10b981'): array
    {
        $p = self::person();
        $t = self::text();
        $css = self::base($accent, $secondary, "'IBM Plex Mono','Courier New',monospace")
            .'.cv-page{padding:0;}'
            .'.cv-side{background:'.$accent.';color:#fff;flex:0 0 32%;width:32%;}'
            .'.cv-main{flex:1 1 0;min-width:0;width:auto;font-family:DM Sans,Arial,sans-serif;}'
            .'.cv-side .cv-h2{color:#fff;border-color:rgba(255,255,255,.3);}'
            .'.cv-side .cv-chip{background:rgba(255,255,255,.12);color:#fff;border-radius:4px;border-color:rgba(255,255,255,.2);}'
            .'.cv-main .cv-name{font-family:IBM Plex Mono,monospace;font-size:26px;color:'.$accent.';}'
            .'.cv-tag{display:inline-block;font-size:10px;letter-spacing:1px;text-transform:uppercase;background:'.$secondary.'26;color:'.$accent.';padding:4px 8px;border-radius:4px;font-weight:700;margin-bottom:10px;}';

        $html = '<div class="cv-page" '.self::region('CV Page').'>'
            .'<div '.self::layoutShell().'>'
            .'<aside class="cv-side" '.self::region('Sidebar').'>'
            .'<div style="margin-bottom:18px;" '.self::region('Identity').'>'
            .'<div '.$t.' style="font-size:17px;font-weight:700;line-height:1.25;">'.$p['name'].'</div>'
            .'<div '.$t.' style="font-size:11px;opacity:.9;margin-top:5px;font-weight:600;">'.$p['role'].'</div></div>'
            .self::section('Contact', '<div '.$t.' class="cv-contact" style="color:#fff;font-size:11px;line-height:1.6;">'.$p['email'].'<br>'.$p['phone'].'<br>'.$p['location'].'</div>')
            .self::section('Stack', '<div>'.self::skillsHtml().'</div>')
            .self::section('Languages', '<div><span '.$t.' class="cv-chip">EN</span><span '.$t.' class="cv-chip">AM</span><span '.$t.' class="cv-chip">FR</span></div>')
            .'</aside>'
            .'<main class="cv-main" '.self::region('Main').'>'
            .'<div '.$t.' class="cv-tag">Available for hire</div>'
            .self::section('Summary', '<div '.$t.' class="cv-p">'.$p['summary'].'</div>')
            .self::section('Experience', self::experienceHtml())
            .self::section('Education', self::educationHtml())
            .'</main>'
            .'</div></div>';

        return compact('html', 'css');
    }
}
