<?php

namespace App\Jobs;

use Exception;
use App\Mail\AccountData;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $models;
    public $subject;
    public $message;
    public function __construct($models, $subject, $message)
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->models = $models;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            foreach ($this->models as $model) {
                Mail::to($model)->send(new AccountData($model, $this->subject, $this->message));
            }
        } catch (Exception $e) {
            // $this->markAsFailed($model, $e);
        }
    }
}
