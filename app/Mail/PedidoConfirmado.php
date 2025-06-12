<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoConfirmado extends Mailable
{
    use Queueable, SerializesModels;

    public $datosPedido;

    /**
     * Create a new message instance.
     */
    public function __construct($datosPedido)
    {
        $this->datosPedido = $datosPedido;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Pedido Confirmado - Indaluz')
                    ->view('emails.pedido-confirmado')
                    ->with('datos', $this->datosPedido);
    }
}