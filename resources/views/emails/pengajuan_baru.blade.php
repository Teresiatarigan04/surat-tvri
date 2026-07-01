<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Surat Baru</title>
</head>

<body style="font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #334155; background-color: #f8fafc; padding: 40px 20px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0;">

        <div style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); padding: 30px; text-align: center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 80" width="150" height="40" style="display: block; margin: 0 auto;">
                <defs>
                    <linearGradient id="blueGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#2563eb" />
                        <stop offset="100%" stop-color="#1d4ed8" />
                    </linearGradient>
                </defs>
                <rect x="10" y="10" width="60" height="60" rx="12" fill="url(#blueGrad)" />
                <path d="M28 26h24v8H44v20h-8V34h-8v-8z" fill="#ffffff" />
                <rect x="80" y="10" width="60" height="60" rx="12" fill="url(#blueGrad)" />
                <path d="M88 26h8l8 20 8-20h8l-12 28h-8l-12-28z" fill="#ffffff" />
                <rect x="150" y="10" width="60" height="60" rx="12" fill="url(#blueGrad)" />
                <path d="M158 26h14c6 0 10 3 10 8s-4 8-10 8h-6v12h-8V26zm14 11c2 0 4-1 4-3s-2-3-4-3h-6v6h6z" fill="#ffffff" />
                <path d="M176 44l8 14h-9l-7-12 8-2z" fill="#ffffff" />
                <rect x="220" y="10" width="60" height="60" rx="12" fill="url(#e11d48)" />
                <rect x="246" y="26" width="8" height="28" fill="#ffffff" />
            </svg>
        </div>

        <div style="padding: 40px 30px;">
            <h2 style="color: #0f172a; margin-top: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.025em;">
                Halo, Admin Sekretariat
            </h2>
            <p style="color: #64748b; font-size: 16px; margin-bottom: 25px;">
                Terdapat pengajuan surat masuk baru dari Admin Divisi yang membutuhkan tinjauan dan verifikasi Anda. Berikut rincian dokumen:
            </p>

            <div style="background-color: #f8fafc; border: 1px solid #f1f5f9; border-radius: 12px; padding: 20px; margin-bottom: 25px;">
                <table style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; font-weight: 600; color: #64748b; width: 140px; vertical-align: top;">No. Surat</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #0f172a; font-weight: 500; vertical-align: top;">
                            {{ $surat->no_surat ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; font-weight: 600; color: #64748b; vertical-align: top;">Pengirim (Divisi)</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #0f172a; font-weight: 500; vertical-align: top;">
                            {{ $surat->pengirim ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; font-weight: 600; color: #64748b; vertical-align: top;">Perihal</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #0f172a; font-weight: 500; vertical-align: top; line-height: 1.5;">
                            {{ $surat->perihal ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; font-weight: 600; color: #64748b; vertical-align: top;">Tanggal Surat</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #0f172a; font-weight: 500; vertical-align: top;">
                            {{ isset($surat->tanggal_surat) ? \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; font-weight: 600; color: #64748b; vertical-align: top;">Sifat Surat</td>
                        <td style="padding: 8px 0; vertical-align: top;">
                            @if(in_array(Str::upper($surat->sifat ?? ''), ['PENTING', 'RAHASIA']))
                            <span style="display: inline-block; background-color: #e70000; color: #ffffff; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.05em;">
                                {{ $surat->sifat }}
                            </span>
                            @elseif(in_array(Str::upper($surat->sifat ?? ''), ['BIASA', 'RUTIN']))
                            <span style="display: inline-block; background-color: #d97706; color: #ffffff; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.05em;">
                                {{ $surat->sifat }}
                            </span>
                            @else
                            <span style="display: inline-block; background-color: #f1f5f9; color: #475569; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.05em;">
                                {{ $surat->sifat ?? 'BIASA' }}
                            </span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div style="background-color: #fffbeb; border: 2px dashed #d97706; border-radius: 12px; padding: 20px; text-align: center; margin-top: 30px;">
                <p style="margin: 0; font-size: 15px; font-weight: 700; color: #b45309; text-transform: uppercase; letter-spacing: 0.05em;">
                    ⚠️ TINDAKAN DIPERLUKAN
                </p>
                <p style="margin: 8px 0 0 0; font-size: 15px; color: #78350f; font-weight: 500; line-height: 1.5;">
                    Silakan log in ke <strong style="color: #d97706; font-size: 16px;">Sistem Aplikasi Manajemen Surat TVRI</strong> untuk memeriksa kelayakan berkas fisik/digital lampiran serta memproses agenda disposisi.
                </p>
            </div>
        </div>

        <div style="background-color: #f8fafc; padding: 25px 30px; text-align: center; border-top: 1px solid #f1f5f9;">
            <p style="margin: 0 0 8px 0; font-size: 12px; color: #94a3b8; line-height: 1.5;">
                Email ini dikirimkan secara otomatis oleh sistem. Mohon untuk tidak membalas email ini.
            </p>
            <p style="margin: 0; font-size: 13px; color: #64748b; font-weight: 600;">
                Sistem Manajemen Surat TVRI Sumatera Utara &copy; 2026
            </p>
        </div>

    </div>
</body>

</html>