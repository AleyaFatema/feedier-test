<?php

namespace App\Console\Commands;

use App\Question;
use Carbon\Carbon;
use App\SurveyResponse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AnswersSoftDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'answers:soft-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Soft deletes answers with empty value from past 24 hours.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info("Answers soft delete is working fine!");
        // ------ Get empty answers from survey_responses table
        $emptyAnswers = SurveyResponse::whereNull('responses')
            ->where(function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(1));// last 24 hours
                $query->whereNull('answer_id')->orWhere('answer_id', '=', 0);
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
        $emptyAnswers->delete();

        $this->info('answers:soft-delete command ran successfully!');
    }
}
