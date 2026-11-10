<?php

namespace App\Support;

class SitemapXml
{
    /**
     * @param  list<array{loc:string,lastmod?:string,changefreq?:string,priority?:string}>  $entries
     */
    public static function urlset(array $entries): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($entries as $entry) {
            $xml .= "    <url>\n";
            $xml .= '        <loc>'.e($entry['loc'])."</loc>\n";
            if (! empty($entry['lastmod'])) {
                $xml .= '        <lastmod>'.e($entry['lastmod'])."</lastmod>\n";
            }
            if (! empty($entry['changefreq'])) {
                $xml .= '        <changefreq>'.e($entry['changefreq'])."</changefreq>\n";
            }
            if (! empty($entry['priority'])) {
                $xml .= '        <priority>'.e($entry['priority'])."</priority>\n";
            }
            $xml .= "    </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * @param  list<array{loc:string}>  $sitemaps
     */
    public static function index(array $sitemaps): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($sitemaps as $sitemap) {
            $xml .= "    <sitemap>\n";
            $xml .= '        <loc>'.e($sitemap['loc'])."</loc>\n";
            $xml .= "    </sitemap>\n";
        }

        $xml .= '</sitemapindex>';

        return $xml;
    }
}
