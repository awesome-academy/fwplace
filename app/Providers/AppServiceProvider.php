<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\ProgramRepository;
use App\Repositories\ProgramInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProgramInterface::class, ProgramRepository::class);
        $this->app->singleton(
            \App\Repositories\Subject\SubjectRepositoryInterface::class,
            \App\Repositories\Subject\SubjectEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Reviews\ReviewRepositoryInterface::class,
            \App\Repositories\Reviews\ReviewEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Roles\RoleRepositoryInterface::class,
            \App\Repositories\Roles\RoleEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Users\UserRepositoryInterface::class,
            \App\Repositories\Users\UserEloquentRepository::class
        );
    }
}
