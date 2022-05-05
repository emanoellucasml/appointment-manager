<?php

namespace App\Services;

use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentSearchService
{
    protected $query;

    public function __construct()
    {
        $this->query = Appointment::query();
        $this->query->orderBy('created_at', 'DESC');
    }

    public function title($title)
    {
        if($title){
            $this->query->where('title', 'like', "%$title%");
        }
        return $this;
    }

    public function description($description)
    {
        if($description){
            $this->query->where('description', 'like', "%$description%");
        }
        return $this;
    }

    public function totalReminders($amountNotification)
    {
        if($amountNotification){
            $this->query->where('notified_amount', '=', $amountNotification);
        }
        return $this;
    }

    public function creationDate($creationDate)
    {
        if($creationDate){
            $creationDate = Carbon::parse($creationDate);
            $this->query->whereDate('created_at', $creationDate->toDateTimeString());
        }
        return $this;
    }

    public function remindDate($remindDate)
    {
        if($remindDate){
            $remindDate = Carbon::parse($remindDate);
            $this->query->whereDate('date_reminder', $remindDate->toDateTimeString());
        }

        return $this;
    }


    public function onlyFutureAppointments($onlyFutureAppointments)
    {
        if($onlyFutureAppointments){
            $this->query->whereDate('date_reminder', '>=', Carbon::now(config('app.timezone')));
        }
        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

}
