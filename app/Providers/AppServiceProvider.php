<?php

namespace App\Providers;

use App\Models\Link;
use App\Models\Reply;
use App\Observers\LinkObserver;
use App\Observers\ReplyObserver;
use Carbon\Carbon;
use Dingo\Api\Facade\API;
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
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
        API::error(function (\Illuminate\Database\Eloquent\Model $model) {
            abort(404);
        });
        API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, $exception->getMessage());
        });
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
        Link::observe(LinkObserver::class);
        //
        Carbon::setLocale("zh");
    }
}
