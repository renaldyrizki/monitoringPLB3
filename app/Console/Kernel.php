<?php

namespace App\Console;

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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $data['nama'] = 'renaldy';
		// $data['link'] = route('backend::mouControl');
		// $data['contact_email'] = "frein.diana@daihatsu.astra.co.id";
		// $data['contact_name'] = 'Frein Diana';
		// $data['item'] = 'P2K3';
		// $data['nomor_izin'] = 'SK/2019';
		// $data['expired_date'] = Date('d-m-Y');
		// $data['status'] = '56 Hari';
		// $data['jenis_izin'] = 'Mou';
		// $data['area'] = 'Plant 2';
		// $data['subject'] = 'LCS Information [NO REPLY]';
		// Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail($data));
        // $schedule->command(new SendTodoReminders())->dailyAt('9:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
