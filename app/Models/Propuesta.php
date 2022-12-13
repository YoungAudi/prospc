<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Mail\Attachment;
use Illuminate\Contracts\Mail\Attachable;

class Propuesta extends Model implements Attachable
{
    use HasFactory;

    /**
     * Get the attachable representation of the model.
     *
     * @return \Illuminate\Mail\Attachment
     */
    public function toMailAttachment()
    {
        return Attachment::fromStorageDisk('public', $this->archivo)
            ->as('propuesta.pdf')
            ->withMime('application/pdf');
    }

    protected $guarded = ['id'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function talento()
    {
        return $this->belongsTo(Talento::class);
    }

    public function adjuntos()
    {
        return $this->hasMany(Adjunto::class);
    }

    public function needs()
    {
        return $this->hasMany(Need::class);
    }

    /**
     * Obtiene la url publica del archivo.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Storage::url($attributes['archivo']),
        );
    }
}
