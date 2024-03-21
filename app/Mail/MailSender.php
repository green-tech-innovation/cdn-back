<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailSender extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->details["subject"],
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        if ($this->details['type'] == "entity_personnal") {
            return new Content(
                view: 'emails.entity_personnal',
            );
        } elseif ($this->details['type'] == "event") {
            return new Content(
                view: 'emails.event',
            );
        } elseif ($this->details['type'] == "forgot-password") {
            return new Content(
                view: 'emails.forgot-password',
            );
        } elseif ($this->details['type'] == "formular") {
            return new Content(
                view: 'emails.formular',
            );
        } elseif ($this->details['type'] == "survey") {
            return new Content(
                view: 'emails.survey',
            );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
