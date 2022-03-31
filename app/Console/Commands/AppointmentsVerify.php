<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tarefa;

class AppointmentsVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointment:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $appointments = Tarefa::all()->filter(function($appointment){
            return $appointment->isToNotify();
        });

        foreach($appointments as $appointment){
            if($appointment->shouldINotifyNow()){
                //event of notification
                $appointment->changeNotificationState();
            }
        }
        return 0;
    }
}
