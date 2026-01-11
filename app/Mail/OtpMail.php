<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code; // Variabel untuk menyimpan kode

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        // Subject email dan view yang digunakan
        return $this->subject('Kode Verifikasi Pendaftaran')
                    ->view('emails.otp');
    }
}