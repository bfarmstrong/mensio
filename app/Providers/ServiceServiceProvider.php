<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * The service provider to provide database services to the container.
 */
class ServiceServiceProvider extends ServiceProvider
{
    /**
     * The services that are exposed to the container.
     *
     * @var array
     */
    public $bindings = [
        \App\Services\Impl\IUserService::class => \App\Services\Impl\UserService::class,
    ];
}
