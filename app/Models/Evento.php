<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function prospecto() 
    {
        return $this->belongsTo(Prospecto::class);
    }

    public function propuestas()
    {
        return $this->hasMany(Propuesta::class);
    }
}
