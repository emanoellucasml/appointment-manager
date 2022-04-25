<?php

namespace App\Console\Commands;

use App\Events\NotifyAppointmentEvent;
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
        /*$appointments = Tarefa::all()->filter(function($appointment){
            return $appointment->isToNotify();
        });*/
        
        $appointments = Tarefa::where(function($q){
            return $q->isToNotify();
        })->get();

        $totalEmailsSent = 0;

        foreach($appointments as $appointment){
            if($appointment->shouldINotifyNow()){
                event(new NotifyAppointmentEvent($appointment));
                $totalEmailsSent++;
            }
        }

        echo "{$totalEmailsSent} emails sent." . PHP_EOL;
        
        return 0;
    }
}
