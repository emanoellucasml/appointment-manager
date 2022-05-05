<?php

namespace App\Models;

use App\Scopes\AppointmentScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'tarefas';

    protected $fillable = [
        'title', 'description', 'date_reminder', 'notified_amount', 'to_notify'
    ];

    protected $casts = [
        'date_reminder' => 'datetime',
        'to_notify' => 'boolean'
    ];


    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isToNotify()
    {
        return $this->to_notify ?? false;
    }

    public function changeNotificationState()
    {
        $this->to_notify = !$this->to_notify;
    }

    public function incrementNotificationAmount()
    {
        $this->notified_amount = $this->notified_amount + 1;
    }

    public function shouldINotifyNow(): bool
    {
        return Carbon::now()->diffInMinutes($this->date_reminder) <= 2;
    }

    protected static function booted()
    {
        static::addGlobalScope(new AppointmentScope());
    }

}
