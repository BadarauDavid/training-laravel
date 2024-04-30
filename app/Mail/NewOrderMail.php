<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $products;
    public $customerName;
    public $customerContact;
    public $comment;

    public function __construct($subject, $products, $customerName, $customerContact, $comment)
    {
        $this->subject = $subject;
        $this->products = $products;
        $this->customerName = $customerName;
        $this->customerContact = $customerContact;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): NewOrderMail
    {
        return $this->subject($this->subject)
            ->view('emails.new_order')
            ->with([
                __('products') => $this->products,
                __('customerName') => $this->customerName,
                __('customerContact') => $this->customerContact,
                __('customerComment') => $this->comment,
            ]);
    }
}
