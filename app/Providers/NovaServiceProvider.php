<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use App\Nova\Metrics\Posts;
use Illuminate\Http\Request;
use Laravel\Nova\Cards\Help;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\Employees;
use App\Nova\Metrics\UsersPerDay;
use Acme\PriceTracker\PriceTracker;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Events\ServingNova;
use App\Nova\Dashboards\UserInsights;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::userTimezone(function (Request $request) {
            return $request->user()->timezone;
        });
        $this->app->booted(function () {
            $this->routes();
        });

        // Nova::serving(function (ServingNova $event) {
        //     Nova::script('stripe-inspector', __DIR__ . '/../dist/js/tool.js');
        //     Nova::style('stripe-inspector', __DIR__ . '/../dist/css/tool.css');
        // });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new Posts,
            new Employees,
            new UsersPerDay
            // Full width...
            // (new Metrics\NewUsers)->width('full'),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new UserInsights,

            // (new \App\Nova\Dashboards\UserInsights)->canSee(function ($request) {
            //     return $request->user()->can('viewUserInsights', User::class);
            // }),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            // new PriceTracker
        ];
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
