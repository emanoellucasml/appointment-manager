<?php

namespace App\Mail;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;


    public $appointment;
    public $owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tarefa $appointment)
    {
        $this->appointment = $appointment;
        $this->owner = $appointment->owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.appointment_reminder');
    }
}
