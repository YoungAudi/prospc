<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\Propuesta;
use App\Models\Talento;
use App\Models\Evento;
use App\Models\Prospecto;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class EnviarPropuesta extends Mailable
{
    use Queueable, SerializesModels;

    public $propuesta;
    public $talento;
    public $evento;
    public $prospecto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Propuesta $propuesta)
    {
        $this->propuesta = $propuesta;
        $this->talento = $propuesta->talento;
        $this->prospecto = $propuesta->evento->prospecto;
        $this->evento = $propuesta->evento;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('sergiogarcia@vgproducciones.com', 'Sergio García') ,
            // to: $this->prospecto->email,
            subject: 'Propuesta para evento',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'email.propuesta',
            // with: [
            //     'url' => route('home')
            // ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $data = [$this->propuesta];
        foreach ($this->propuesta->adjuntos as $adjunto) {
            $data[] = $adjunto;
        }
        return $data;
    }
}
