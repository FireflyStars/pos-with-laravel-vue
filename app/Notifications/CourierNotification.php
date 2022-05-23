<?php

namespace App\Notifications;

use App\Models\Campagne;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourierNotification extends Notification
{
    use Queueable;

    public $campagne;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Campagne $campagne)
    {
        $this->campagne = $campagne;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.courierEmail', [
            'campagne'          => $this->campagne,
            'campagne_category' => $campagne_category = $this->campagne->campagneCategory,
            'url'               => rtrim(config('app.url'), '/'),
            'filedepliant'      => $this->get_filedepliant($campagne_category),
            'fileenveloppe'      => $this->get_fileenveloppe($campagne_category),
        ])
        ->subject($this->campagne->campagneCategory->objet);
    }

    private function get_filedepliant($campagne_category) 
    {
        $file = json_decode($campagne_category->filedepliant, true);
        return count($file) ? $file[0]['download_link'] : '';
    }
    
    private function get_fileenveloppe($campagne_category) 
    {
        $file = json_decode($campagne_category->fileenveloppe, true);
        return count($file) ? $file[0]['download_link'] : '';
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
