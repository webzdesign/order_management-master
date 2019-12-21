<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlaceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $dealer;
    public $city;
    public $date;
    public $productName;	
    public $subject;
    public $description;
	public $order_detail;

    public function __construct($order, $dealer, $city, $date, $productName, $subject, $description, $order_detail)
    {
        $this->order = $order;
        $this->dealer = $dealer;
        $this->city = $city;
        $this->date = $date;
        $this->productName = $productName;		
        $this->subject = $subject;
        $this->description = $description;
		$this->order_detail = $order_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order =  $this->order;
        $dealer = $this->dealer;
        $city = $this->city;
        $date = $this->date;
        $productName = $this->productName;	
        $subject = $this->subject;
        $description = $this->description;
		$order_detail = $this->order_detail;

        return $this->view('getordermail', compact ('order', 'dealer', 'city', 'date', 'productName', 'subject', 'description', 'order_detail'));
    }
}
