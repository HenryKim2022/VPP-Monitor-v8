<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $url; // Property to hold the reset URL

    /**
     * Create a new message instance.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url; // Assign the URL to the property
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:  env('APP_NAME') . ': Account Password Reset',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'pages/auths/p_mailed_password_request_reset',
            with: [
                'site_name' => env('APP_NAME'),
                'site_owner' => env('APP_OWNER'),
                'url' => $this->url,
                'logoPath' => public_path('assets/logo/vp_logo.svg'), // Use public_path
                'resetImagePath' => public_path('theme/vuexy/app-assets/images/pages/reset-password-v2-dark.svg'), // Use public_path
            ]
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
}
