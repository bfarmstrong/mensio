<?php

namespace App\Notifications;

use App\Models\Receipt;
use App\Services\Impl\IReceiptService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * When a receipt is created the PDF document is sent to the client.
 */
class ReceiptCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param Receipt $receipt
     */
    public function __construct(Receipt $receipt)
    {
        $this->receipt = $receipt;
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $receiptService = app(IReceiptService::class);
        $pdf = $receiptService->exportAsPdf($this->receipt);

        return (new MailMessage())
            ->line(__('notifications.ReceiptCreated.receipt-created'))
            ->attachData(
                $pdf->output(),
                __('notifications.ReceiptCreated.receipt').'.pdf'
            );
    }
}
