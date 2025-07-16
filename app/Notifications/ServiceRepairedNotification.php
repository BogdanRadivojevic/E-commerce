<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceRepairedNotification extends Notification
{
    use Queueable;

    protected $productService;
    public function __construct($productService)
    {
        $this->productService = $productService;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable): array
    {
        return [
            'product_service_id' => $this->productService->id,
            'device_name' => $this->productService->device_name,
            'issue_description' => $this->productService->issue_description,
            'price' => $this->productService->price,
            'status' => $this->productService->status,
            'finished_at' => $this->productService->finished_at,
        ];
    }

}
