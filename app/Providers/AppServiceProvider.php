<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Services\SeoService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::anonymousComponentPath(
            resource_path('views/website/components'),
            'website'
        );

        Blade::anonymousComponentPath(
            resource_path('views/webadmin/components'),
            'webadmin'
        );

        View::composer('website.*', function ($view) {
            $view->with('seo', app(SeoService::class)->resolveForRequest());
            $view->with('siteLogoUrl', SiteSetting::logoUrl());
            $view->with('siteSettings', SiteSetting::websiteSettings());
        });

        View::composer('website.sections.hero', function ($view) {
            $view->with('heroSlides', HeroSlide::query()->active()->get());
        });

        View::composer('website.sections.products', function ($view) {
            $view->with('products', Product::query()->active()->get());
        });

        View::composer('website.sections.services-grid', function ($view) {
            $view->with('services', Service::query()->active()->get());
        });

        View::composer('website.partials.header', function ($view) {
            $view->with('menuProducts', Product::query()->active()->get());
        });

        View::composer(['website.sections.team', 'website.pages.about'], function ($view) {
            $view->with('teamMembers', TeamMember::query()->active()->get());
        });

        View::composer(['website.sections.faq', 'website.pages.faq', 'website.pages.pricing'], function ($view) {
            $view->with('faqs', Faq::query()->active()->get());
        });

        View::composer(['website.sections.blog', 'website.home'], function ($view) {
            $view->with('latestBlogs', Blog::query()->published()->with('category')->latest('published_at')->limit(3)->get());
        });
    }
}
