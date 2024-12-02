<?php

namespace App\Http\Controllers\Life;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoVerificacionCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Código de Verificación')
                    ->view('fyl/life.codigo_verificacion');
    }
}
