<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeCategories();
        $this->composeCategorySelect();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function composeCategories()
    {
        view()->composer('layouts.partials.sidebar', function($view) {
            $view->with('categories', Category::all());
        });
    }

    protected function composeCategorySelect()
    {
        view()->composer('layouts.partials.categoryselect', function($view) {
            $view->with('categories', Category::all());
        });
    }
}
