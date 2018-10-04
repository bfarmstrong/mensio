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
        \App\Services\Impl\IQuestionnaireService::class => \App\Services\Impl\QuestionnaireService::class,
        \App\Services\Impl\IQuestionService::class => \App\Services\Impl\QuestionService::class,
        \App\Services\Impl\IResponseService::class => \App\Services\Impl\ResponseService::class,
        \App\Services\Impl\ISurveyService::class => \App\Services\Impl\SurveyService::class,
        \App\Services\Impl\IUserService::class => \App\Services\Impl\UserService::class,
    ];
}
