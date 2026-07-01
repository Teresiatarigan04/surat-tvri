<?php

namespace App\Mail;

use App\Models\Disposisi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisposisiBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public $disposisi;

    public function __construct(Disposisi $disposisi)
    {
        $this->disposisi = $disposisi;
    }

    public function build()
    {
        return $this->subject('NOTIFIKASI DISPOSISI BARU' )
                    ->view('emails.disposisi_baru');
    }
}