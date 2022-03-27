<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefas';

    protected $fillable = [
        'title', 'description', 'date_reminder'
    ];

    public function owner(){
        return $this->belongsTo(User::class);
    }
}
