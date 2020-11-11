<?php

namespace App\Jobs;

use App\Mail\NotifyAnswersToAdmin;
use App\Question;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyAnswersToAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all textarea type questions
        $responses = Question::whereHas('responses', function($q) {
                //$q->whereDate('created_at', '=', Carbon::today());
                $q->where('created_at', '>=', Carbon()->now()->subDay());// last 24 hours
                $q->where('created_at', '>=', Carbon()->now()->subDay(2));// last 48 hours
                $q->whereDate('created_at', '!=', Carbon::today());
            })->with(['responses'=> function($q) {
                //$q->whereDate('created_at', '=', Carbon::today());
                $q->where('created_at', '>=', Carbon()->now()->subDay());// last 24 hours
                $q->where('created_at', '>=', Carbon()->now()->subDay(2));// last 48 hours
                $q->whereDate('created_at', '!=', Carbon::today());
            }])
            ->where('type', '=', 2)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // get the admin email
        $admin_email = env('APP_ADMIN_EMAIL');
        // Send the app admin email notification about the last textarea question's answers
        Mail::to($admin_email)->send(new NotifyAnswersToAdmin($responses));
    }
}
