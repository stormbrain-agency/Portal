<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\NotificationMail;

class MracAracMailAdmin extends Mailable
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
        return new Envelope(
            subject: 'Alert: MRAC/ARAC Submission Received',
        );
    }

    /**
     * Get email content from the database based on the name_form.
     *
     * @return array
     */
    protected function getEmailContent(): array
    {
        $nameForm = $this->data['name_form'] ?? null;

        if ($nameForm) {
            $notificationMail = NotificationMail::where('name_form', $nameForm)->first();

            if ($notificationMail) {
                return [
                    'subject' => $notificationMail->subject,
                    'body' => $notificationMail->body,
                    'button_title' => $notificationMail->button_title,
                ];
            }
        }
        // Default values if no matching record is found
        return [
            'subject' => 'Default Subject',
            'body' => 'Default Body',
            'button_title' => 'Default Button Title',
        ];
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $emailContent = $this->getEmailContent();
        return new Content(
            view: 'mail.admin.mrac-arac',
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
