<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
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
        return $this->belongsTo(User::class);
    }

    public function isToNotify()
    {
        return $this->to_notify;
    }
}
