<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


use App\Services\CategoryService;
use App\Repository\CategoryRepository;
use App\Services\ICategoryService;
use App\Repository\ICategoryRepository;

use App\Services\TagService;
use App\Repository\TagRepository;
use App\Services\ITagService;
use App\Repository\ITagRepository;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        Schema::defaultStringLength(191);
        $this->app->bind(ICategoryService::class, CategoryService::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(ITagService::class, TagService::class);
        $this->app->bind(ITagRepository::class, TagRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
