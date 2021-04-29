<?php

namespace App\Nova\Actions;

use App\Jobs\SendEmails;
use App\Mail\AccountData;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class EmailAccountProfile extends Action implements ShouldQueue
{
    public $withoutActionEvents = true;

    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        SendEmails::dispatch($models, $fields->subject, $fields->message);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Subject')->rules('required'),
            Textarea::make('message')->rules('required'),

        ];
    }
    public function name()
    {
        return __('Send an Announcement ');
    }
    // public function __construct()
    // {
    //     $this->connection = 'database';
    //     $this->queue = 'emails';
    // }
}
