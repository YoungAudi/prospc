<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Prospecto extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
