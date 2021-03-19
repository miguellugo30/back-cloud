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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('fallo.bc@citics.com.mx')
                    ->subject("Recibo de Gas, 2G Administradora de Gas LP en Condominios")
                    ->view('mail.errorBack');

        //return $this->view('view.name');
    }

    public function failed(Exception $exception)
    {
        // usually would send new notification to admin/user
        Log::info($exception);
    }
}
