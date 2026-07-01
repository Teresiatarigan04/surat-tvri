<?php

namespace App\Mail;

use App\Models\SuratMasuk;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanSuratBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public $surat;

    public function __construct(SuratMasuk $surat)
    {
        $this->surat = $surat;
    }

    public function build()
    {
        // Mengambil email & nama admin divisi yang sedang login secara otomatis
        $senderEmail = auth()->user()->email;
        $senderName = auth()->user()->nama ?? auth()->user()->name;

        return $this->from($senderEmail, $senderName)
            ->subject('PENGAJUAN SURAT BARU - ' . $this->surat->no_surat)
            ->view('emails.pengajuan_baru');
    }
}
