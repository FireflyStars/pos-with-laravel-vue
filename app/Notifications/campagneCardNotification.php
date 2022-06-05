<?php

namespace App\Notifications;

use App\Models\Campagne;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class campagneCardNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $campagne;
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

        return (new MailMessage)->markdown('mail.campagneCardEmail', [
            'campagne'          => $this->campagne,
            'total'             => $this->get_total(),
            'tax'               => $this->get_tax(),
            'total_with_tax'    => $this->get_total_with_tax(),
        ])
        ->subject('COMMANDE N : ' . $this->campagne->id);
    }

    private function get_total() 
    {
        $total = 0;
        $this->campagne->details->each(function($product) use (&$total) {
            $total += $product->price * $product->qty;
        });
        return $total;
    }

    private function get_tax() 
    {
        $total = $this->get_total();
        $taxTotal = $this->campagne->details->pluck('tax.taux')->sum();
        return $total * $taxTotal;
    }

    private function get_total_with_tax() 
    {
        return $this->get_total() + $this->get_tax();
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
