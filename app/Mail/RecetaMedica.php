<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecetaMedica extends Mailable
{
    use Queueable, SerializesModels;
    public $contact;
    public $datos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact, $datos)
    {
        //
        $this->contact = $contact;
        $this->contact = $datos;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Receta Medica',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function build()
    {
        return $this->from('hdzv.jorgeluis@gmail.com', 'no-reply')
            ->to($this->contact)
            ->view('ConsultaGeneral.Email');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
