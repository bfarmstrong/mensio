<?php

namespace App\Notifications;

use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use URL;

/**
 * Notification for when a questionnaire is assigned to a user.
 */
class QuestionnaireAssigned extends Notification
{
    use Queueable;

    /**
     * The response object.
     *
     * @var Response
     */
    protected $response;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line(__('notifications.QuestionnaireAssigned.you-have-been-invited'))
            ->action(
                __('notifications.QuestionnaireAssigned.view-questionnaire'),
                URL::signedRoute('responses.show-external', [
                    'response_id' => $this->response->uuid,
                ])
            );
    }
}
