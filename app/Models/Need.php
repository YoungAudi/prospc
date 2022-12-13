<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function propuesta()
    {
        return $this->belongsTo(Propuesta::class);
    }
}
