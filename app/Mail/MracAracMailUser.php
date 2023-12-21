<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\NotificationMail;

class MracAracMailUser extends Mailable
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

        if (in_array('mRec/aRec User', $nameForms)) {
            foreach ($nameForms as $nameForm) {
                if ($nameForm === 'mRec/aRec User') {
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
            'subject' => 'Confirmation: mRec/aRec Submission Received',
            'body' => 'We have received your mRec/aRec submission. The details of the submission are as follows:',
            'button_title' => 'View Submission History',
        ];
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $emailContent = $this->getEmailContent();
        return new Content(
            view: 'mail.user.mrac-arac',
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
