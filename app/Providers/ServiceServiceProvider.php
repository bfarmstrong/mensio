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
        \App\Services\Impl\IAnswerService::class => \App\Services\Impl\AnswerService::class,
        \App\Services\Impl\IDoctorService::class => \App\Services\Impl\DoctorService::class,
        \App\Services\Impl\INoteService::class => \App\Services\Impl\NoteService::class,
        \App\Services\Impl\IQuestionGridService::class => \App\Services\Impl\QuestionGridService::class,
        \App\Services\Impl\IQuestionItemService::class => \App\Services\Impl\QuestionItemService::class,
        \App\Services\Impl\IQuestionnaireService::class => \App\Services\Impl\QuestionnaireService::class,
        \App\Services\Impl\IQuestionService::class => \App\Services\Impl\QuestionService::class,
        \App\Services\Impl\IResponseService::class => \App\Services\Impl\ResponseService::class,
        \App\Services\Impl\IRoleService::class => \App\Services\Impl\RoleService::class,
        \App\Services\Impl\ISurveyService::class => \App\Services\Impl\SurveyService::class,
        \App\Services\Impl\IUserService::class => \App\Services\Impl\UserService::class,
    ];
}
