<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class CreateOrder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $products;
    public $sum_cart;
    public $count_products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $products, $sum_cart, $count_products)
    {
        $this->products = $products;
        $this->sum_cart = $sum_cart;
        $this->count_products = $count_products;

        $this->onQueue('emails');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ваш заказ оформлен!')
            ->view('emails.create-order');
    }
}
