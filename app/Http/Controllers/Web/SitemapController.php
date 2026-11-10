<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Support\FrontSeo;
use App\Support\SitemapXml;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        return $this->xml(SitemapXml::index(FrontSeo::sitemapIndexEntries()));
    }

    public function pages(): Response
    {
        return $this->xml(SitemapXml::urlset(FrontSeo::pagesSitemapEntries()));
    }

    public function jobs(): Response
    {
        return $this->xml(SitemapXml::urlset(FrontSeo::jobsSitemapEntries()));
    }

    public function companies(): Response
    {
        return $this->xml(SitemapXml::urlset(FrontSeo::companiesSitemapEntries()));
    }

    public function posts(): Response
    {
        return $this->xml(SitemapXml::urlset(FrontSeo::postsSitemapEntries()));
    }

    private function xml(string $body): Response
    {
        return response($body, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
