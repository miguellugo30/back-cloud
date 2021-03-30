<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ErrorBack extends Mailable
{
    use Queueable, SerializesModels;

    private $empresa;
    private $url;
    private $fecha;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $empresa, $url, $fecha )
    {
        $this->empresa = $empresa;
        $this->url = $url;
        $this->fecha = $fecha;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('fallo.bc@citics.com.mx')
                    ->subject("Back-Cloud, Error en respaldo")
                    ->view('mail.errorBack')
                    ->with([
                        'empresa' => $this->empresa,
                        'url' => $this->url,
                        'fecha' => $this->fecha
                    ]);

        //return $this->view('view.name');
    }

    public function failed(Exception $exception)
    {
        // usually would send new notification to admin/user
        Log::info($exception);
    }
}
