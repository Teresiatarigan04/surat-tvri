<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class DisposisiSekretController extends Controller
{
    public function index()
    {
        $disposisis = Disposisi::with(['surat', 'penerima', 'dariAdmin'])->latest()->get();

        $balasan_disposisi = Disposisi::with(['surat', 'dariAdmin', 'penerima', 'balasan'])
            ->whereIn('status', ['selesai dilaksanakan', 'sudah dibaca'])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->is_balasan = true;
                return $item;
            });

        $surat_tersedia = SuratMasuk::whereIn('status', ['pending', 'diproses'])->get();
        $admin_divisi = User::where('role', 'ADMINDIVISI')->get();

        $stats = [
            'total'   => Disposisi::count(),
            'pending' => Disposisi::whereIn('status', ['pending', 'sedang dilaksanakan', 'diproses'])->count(),
            'selesai' => Disposisi::whereIn('status', ['selesai dilaksanakan', 'sudah dibaca'])->count(),
        ];

        return view('adminsekret.DisposisiSekret', compact(
            'disposisis',
            'balasan_disposisi',
            'stats',
            'surat_tersedia',
            'admin_divisi'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,sedang dilaksanakan,selesai dilaksanakan,diproses,sudah dibaca'
        ]);

        try {
            $disposisi = Disposisi::findOrFail($id);
            $disposisi->update(['status' => $request->status]);

            return back()->with('success', 'Status disposisi berhasil diubah!');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // Validasi input dengan pesan kustom Bahasa Indonesia
        $request->validate([
            'surat_id'         => 'required|exists:surat_masuk,id',
            'ke_admin'         => 'required|array|min:1',
            'ke_admin.*'       => 'exists:users,id',
            'instruksi'        => 'required|array|min:1',
            'catatan_tambahan' => 'nullable|string',
            'file_disposisi'   => 'required|mimes:pdf,doc,docx|max:1024', // Maksimal 1MB
            'peran'            => 'required|array',
            'ketua_tim'        => 'nullable|array',
        ], [
            'surat_id.required'       => 'Pilih surat yang ingin didisposisikan.',
            'ke_admin.required'       => 'Harap pilih minimal satu admin divisi tujuan.',
            'instruksi.required'      => 'Pilih minimal satu instruksi disposisi.',
            'file_disposisi.required' => 'File lampiran disposisi wajib diunggah.',
            'file_disposisi.mimes'    => 'Format dokumen harus berupa PDF, DOC, atau DOCX.',
            'file_disposisi.max'      => 'Ukuran dokumen terlalu besar. Maksimal adalah 1 MB.',
        ]);

        $fileName = null;

        try {
            DB::beginTransaction();

            if ($request->hasFile('file_disposisi')) {
                $file = $request->file('file_disposisi');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/surat_disposisi');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);
            }

            $instruksiTerpilih = $request->instruksi ? implode(', ', $request->instruksi) : '';
            $catatanFinal = $instruksiTerpilih;
            if ($request->catatan_tambahan) {
                $catatanFinal .= ($catatanFinal ? ' | Catatan: ' : '') . $request->catatan_tambahan;
            }

            foreach ($request->ke_admin as $adminId) {
                $peranRaw = $request->peran[$adminId] ?? 'pelaksana';
                $peranUser = is_array($peranRaw) ? reset($peranRaw) : $peranRaw;

                $getuaTimRaw = $request->ketua_tim[$adminId] ?? null;
                $ketuaTimUser = is_array($getuaTimRaw) ? reset($getuaTimRaw) : $getuaTimRaw;

                if (!in_array($peranUser, ['pelaksana', 'pemantau'])) {
                    $peranUser = 'pelaksana';
                }

                $statusAwal = 'pending';

                Disposisi::create([
                    'surat_id'       => $request->surat_id,
                    'dari_admin'     => Auth::id(),
                    'ke_admin'       => $adminId,
                    'catatan'        => $catatanFinal,
                    'file_disposisi' => $fileName,
                    'status'         => $statusAwal,
                    'peran'          => $peranUser,
                    'ketua_tim'      => $ketuaTimUser,
                ]);
            }

            $surat = SuratMasuk::findOrFail($request->surat_id);
            $surat->update(['status' => 'diproses']);

            DB::commit();
            return back()->with('success', 'Surat berhasil didisposisikan!');
        } catch (Exception $e) {
            DB::rollBack();
            if ($fileName && file_exists(public_path('uploads/surat_disposisi/' . $fileName))) {
                unlink(public_path('uploads/surat_disposisi/' . $fileName));
            }
            return back()->with('error', 'Gagal memproses disposisi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $disposisi = Disposisi::with(['surat', 'dariAdmin', 'penerima', 'balasan'])->findOrFail($id);
            return response()->json($disposisi);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'surat_id'       => 'required|exists:surat_masuk,id',
            'ke_admin'       => 'required|array|min:1',
            'ke_admin.*'     => 'exists:users,id',
            'instruksi'      => 'nullable|array',
            'catatan'        => 'nullable|string',
            'file_disposisi' => 'nullable|mimes:pdf,doc,docx|max:1024',
            'peran'          => 'required|in:pelaksana,pemantau',
            'ketua_tim'      => 'nullable|string|max:255',
        ], [
            'file_disposisi.mimes' => 'Format pembaruan dokumen harus berupa PDF, DOC, atau DOCX.',
            'file_disposisi.max'   => 'Ukuran pembaruan dokumen maksimal adalah 1 MB.',
        ]);

        $fileName = null;

        try {
            DB::beginTransaction();
            $disposisi = Disposisi::with('surat')->findOrFail($id);

            $instruksiTerpilih = $request->instruksi ? implode(', ', $request->instruksi) : '';
            $catatanFinal = $instruksiTerpilih;
            if ($request->catatan) {
                $catatanFinal .= ($catatanFinal ? ' | Catatan: ' : '') . $request->catatan;
            }

            if ($request->hasFile('file_disposisi')) {
                $file = $request->file('file_disposisi');
                $fileName = time() . '_update_' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/surat_disposisi');

                if ($disposisi->file_disposisi && file_exists($destinationPath . '/' . $disposisi->file_disposisi)) {
                    unlink($destinationPath . '/' . $disposisi->file_disposisi);
                }

                $file->move($destinationPath, $fileName);
                $disposisi->file_disposisi = $fileName;
            }

            $disposisi->update([
                'surat_id'  => $request->surat_id,
                'ke_admin'  => $request->ke_admin[0],
                'catatan'   => $catatanFinal,
                'peran'     => $request->peran,
                'ketua_tim' => $request->ketua_tim,
            ]);

            $this->logAction($request, 'Memperbarui data disposisi surat No: ' . ($disposisi->surat ? $disposisi->surat->no_surat : '-'));

            DB::commit();
            return back()->with('success', 'Disposisi berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollBack();
            if ($fileName && file_exists(public_path('uploads/surat_disposisi/' . $fileName))) {
                unlink(public_path('uploads/surat_disposisi/' . $fileName));
            }
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $disposisi = Disposisi::with('surat')->findOrFail($id);
            $no_surat = $disposisi->surat ? $disposisi->surat->no_surat : 'Tidak diketahui';

            if ($disposisi->surat) {
                $sisaDisposisi = Disposisi::where('surat_id', $disposisi->surat_id)
                    ->where('id', '!=', $id)
                    ->count();

                if ($sisaDisposisi == 0) {
                    $disposisi->surat->update(['status' => 'pending']);
                }
            }

            if ($disposisi->file_disposisi && file_exists(public_path('uploads/surat_disposisi/' . $disposisi->file_disposisi))) {
                unlink(public_path('uploads/surat_disposisi/' . $disposisi->file_disposisi));
            }

            $disposisi->delete();

            $this->logAction($request, 'Menghapus data disposisi surat No: ' . $no_surat);

            DB::commit();
            return back()->with('success', 'Disposisi berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    private function logAction($request, $aktivitas)
    {
        LogActivity::create([
            'user_id'    => Auth::id(),
            'username'   => Auth::user()->username,
            'role'       => Auth::user()->role,
            'halaman'    => 'Manajemen Disposisi',
            'aktivitas'  => $aktivitas,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
