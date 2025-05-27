<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class OrderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $customer;
    public $order_code;

    public function __construct($customer, $order_code)
    {
        $this->customer = $customer;
        $this->order_code = $order_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác nhận đơn hàng thành công - TT Fashion Shop')
            ->view('emails.success')
            ->with([
                'name' => Crypt::decryptString($this->customer->customer_name),
                'code' => $this->order_code,
            ]);
    }
}
