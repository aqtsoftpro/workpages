<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MultiPurposeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $content
     */
    public function __construct($subject, $content, $url)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            ->view('emails.workpages-template')
            ->with([
                'content' => $this->content,
                'url' => $this->url,
            ]);
    }
}
