<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $notification;
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification Mail',
        );
    }
    public function build()
    {
        return $this->subject('New Message from COOPERATIBA')
                    ->view('emails.chatFromAdmin') // Match your Blade file
                    ->with('notification', $this->notification);
    }
}
