<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ArticleHit'=>[
	        'App\Listeners\ArticleHitListener',
        ],
	    'App\Events\CourseHit'=>[
	        'App\Listeners\CourseHitListener',
        ],
	    'App\Events\VideoHit'=>[
	        'App\Listeners\VideoHitListener',
        ],
	    'App\Events\VideoSectionHit'=>[
	        'App\Listeners\VideoSectionHitListener',
        ],
	    'App\Events\CollegeHit'=>[
	        'App\Listeners\CollegeHitListener',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
