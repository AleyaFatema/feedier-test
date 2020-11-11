<?php

namespace App\Console;

use App\Jobs\NotifyAnswersToAdminJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\AnswersSoftDelete::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        #######################################################################
        ######### TEST 2: Email last 2 days textarea answers to admin #########
        #######################################################################
        $schedule->job(new NotifyAnswersToAdminJob())->cron('0 8 */2 * *'); //minute, hour, day of month, month and day of week
//        $schedule->job(new NotifyAnswersToAdminJob())->everyMinute();


        ################################################
        ######### TEST 3: Delete empty answers #########
        ################################################
        $schedule->command('answers:soft-delete')
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
