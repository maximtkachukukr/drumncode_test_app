<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Task;
use App\Repositories\User\TaskRepository;
use App\Repositories\User\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, function ($app) {
            return new TaskRepository(new Task());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
