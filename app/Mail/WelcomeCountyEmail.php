<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\NotificationMail;

class WelcomeCountyEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $emailContent = $this->getEmailContent();
        return new Envelope(
            subject: $emailContent['subject'],
        );
    }

    /**
     * Get email content from the database based on the name_form.
     *
     * @return array
     */
    protected function getEmailContent(): array
    {
        $nameForms = NotificationMail::pluck('name_form')->all();

        if (in_array('Welcome County Email', $nameForms)) {
            foreach ($nameForms as $nameForm) {
                if ($nameForm === 'Welcome County Email') {
                    $notificationMail = NotificationMail::where('name_form', $nameForm)->get();

                    if ($notificationMail->isNotEmpty()) {
                        return [
                            'subject' => $notificationMail->pluck('subject')->first(),
                            'body' => $notificationMail->pluck('body')->first(),
                            'button_title' => $notificationMail->pluck('button_title')->first(),
                        ];
                    }
                }
            }
        }
        return [
            'subject' => 'Welcome to the Supplemental Rate Payment Program',
            'body' => '<p>Congratulations! You are now part of the Supplemental Rate Payment Program.</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

            <ul style="color: #002559;">
                <li>Proin eu metus eu est tincidunt auctor.</li>
                <li>Integer vitae elit nec justo bibendum fermentum.</li>
                <li>Curabitur sit amet libero in urna tristique laoreet.</li>
            </ul>

            <ol style="color: #002559;">
                <li>Duis condimentum urna in lacus sagittis, vitae fringilla odio fermentum.</li>
                <li>Vivamus eu nisi ac justo congue pulvinar.</li>
                <li>Fusce auctor justo eu metus vehicula, vitae laoreet purus imperdiet.</li>
            </ol>',
            'button_title' => 'Login Now',
        ];
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $emailContent = $this->getEmailContent();
        return new Content(
            view: 'mail.welcome-email',
            with: [
                'data' => $this->data,
                'emailContent' => $emailContent,
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
