<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NotifyAppointmentEvent;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotifyAppointmentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotifyAppointmentEvent $event)
    {
        $appointment = $event->appointment;
        try{
            DB::transaction(function() use($appointment){
                $appointment->changeNotificationState();
                $appointment->incrementNotificationAmount();
                $appointment->save();
            });
            
            Mail::to($appointment->owner->email)
                    ->cc('Lembrete')
                    ->send(new AppointmentReminder($appointment));
        }catch(\Exception $e){
            info($e->getMessage());
        }
    }
}
