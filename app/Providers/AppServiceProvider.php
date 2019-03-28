<?php

namespace App\Providers;

use App\Models\CollegeSection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
	    Schema::defaultStringLength(191);
	    Relation::morphMap([
		    CollegeSection::COURSE => 'App\Models\Course',
		    CollegeSection::VIDEO => 'App\Models\Video',
		    CollegeSection::ARTICLE => 'App\Models\Article',
	    ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
