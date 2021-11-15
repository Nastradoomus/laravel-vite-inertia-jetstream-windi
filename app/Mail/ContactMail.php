<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $reply_to, $message, $sender, $email)
    {
        $this->name = $name;
        $this->reply_to = $reply_to;
        $this->message = $message;
        $this->sender = $sender;
        $this->email = $email;
    } //end __construct()

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->sender == "contact") {
            $subject = "Yhteydenottopyyntö Villa Sibbe -sivustolta";
        } elseif ($this->sender == "feedback") {
            $subject = "Palautetta Villa Sibbe -sivustolta";
        } elseif ($this->sender == "restaurant") {
            $subject = "Ravintolatiedustelu Villa Sibbe -sivustolta";
        } elseif ($this->sender == "cafe") {
            $subject = "Kahvilatiedustelu Villa Sibbe -sivustolta";
        } elseif ($this->sender == "festivity") {
            $subject = "Juhlatilatiedustelu Villa Sibbe -sivustolta";
        } else {
            $subject = "Tuntematon " . $this->sender . ", ilmoittakaa verkkovastaavalle) tiedustelu Villa Sibbe -sivustolta";
        } //end if
        return $this->from($this->email, $this->name)
            ->replyTo($this->reply_to, $this->name)
            ->subject($subject)
            ->view("contact")
            ->with("name", $this->name)
            ->with("email", $this->email)
            ->with("body", $this->message)
            ->with("reply_to", $this->reply_to);
    } //end build()
} //end class
