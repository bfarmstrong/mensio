<?php

namespace App\Observers;

use App\Models\Response;
use App\Notifications\QuestionnaireAssigned;
use Notification;

/**
 * Handles lifecycle events for the Response model.
 */
class ResponseObserver
{
    /**
     * Handle the "created" event for a response.
     *
     * @param Response $response
     *
     * @return void
     */
    public function created(Response $response)
    {
        $response->load('user');
        Notification::send($response->user, new QuestionnaireAssigned($response));
    }
}
