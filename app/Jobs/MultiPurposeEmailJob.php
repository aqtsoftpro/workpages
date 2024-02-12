<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\MultiPurposeEmail;
use Mail;

class MultiPurposeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $table = 'queue_jobs';
    protected $To;
    protected $subject;
    protected $originalContent;
    protected $verificationUrl;
    /**
     * Create a new job instance.
     */
    public function __construct($To, $subject, $originalContent, $verificationUrl)
    {
        $this->To = $To;
        $this->subject = $subject;
        $this->originalContent = $originalContent;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new MultiPurposeEmail($this->subject, $this->originalContent, $this->verificationUrl);
        Mail::to($this->To)->send($email);
    }
}
