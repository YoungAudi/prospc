<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Talento extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function propuestas()
    {
        return $this->hasMany(Propuesta::class);
    }

    protected function portada(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Storage::url($attributes['imagen']),
        );
    }
}
