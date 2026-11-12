<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // категории для меню на всех страницах витрины
        View::composer('layouts.app', function ($view) {
            $view->with('navCategories', Category::orderBy('name')->get());
        });
    }
}
