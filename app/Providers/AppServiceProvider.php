<?php

namespace App\Providers;

use App\Models\Reply;
use App\Observers\ReplyObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		\App\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        //
        Carbon::setLocale("zh");
    }
}
