<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $otpCode;
    protected $recipientName;
    public function __construct($otpCode, $recipientName)
    {
        $this->otpCode = $otpCode;
        $this->recipientName = $recipientName;
    }



    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Otp Code', 
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.otp',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->markdown('emails.otp')
            ->with([
                'otp' => $this->otpCode,
                'recipientName' => $this->recipientName,
            ]);
    }
}
