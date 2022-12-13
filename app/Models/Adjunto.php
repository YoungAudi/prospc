<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Attachment;
use Illuminate\Contracts\Mail\Attachable;

class Adjunto extends Model implements Attachable
{
    use HasFactory;

    protected $guarded = ['id'];

    public function propuesta()
    {
        return $this->belongsTo(Propuesta::class);
    }

    /**
     * Get the attachable representation of the model.
     *
     * @return \Illuminate\Mail\Attachment
     */
    public function toMailAttachment()
    {
        return Attachment::fromStorageDisk('public', $this->archivo)
            ->as($this->nombre.'.pdf')
            ->withMime('application/pdf');
    }
}
