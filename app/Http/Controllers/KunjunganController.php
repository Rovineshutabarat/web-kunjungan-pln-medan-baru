<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\Storage;

class KunjunganController extends Controller
{
    public function index()
    {
        $kunjungans = DB::table('kunjungan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kunjungan.index', compact('kunjungans'));
    }

    /** 
     * Menampilkan form tambah data kunjungan
     */
    public function create()
    {
        // proteksi session
        if (!Session::get('petugas_login')) {
            return redirect('/login-petugas');
        }

        return view('kunjungan.create');
    }

    /**
     * Menyimpan data kunjungan baru
     */
    public function store(Request $request)
    {
        // proteksi session
        if (!Session::get('petugas_login')) {
            return redirect('/login-petugas');
        }


        $request->validate([
            'id_pelanggan' => 'required|unique:kunjungan,id_pelanggan',
            'nik' => 'required|size:16|unique:kunjungan,nik',
            'no_hp' => 'required',
            'tujuan' => 'required',
            'petugas' => 'required',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_selfi' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'id_pelanggan.required' => 'ID Pelanggan wajib diisi',
            'id_pelanggan.unique' => 'ID Pelanggan sudah terdaftar',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'foto_ktp.required' => 'Foto KTP wajib diupload',
            'foto_ktp.image' => 'File harus berupa gambar',
            'foto_ktp.mimes' => 'Format foto harus jpg, jpeg, atau png',
            'foto_selfi.required' => 'Foto Selfie wajib diupload',
            'foto_selfi.image' => 'File harus berupa gambar',
            'foto_selfi.mimes' => 'Format foto harus jpg, jpeg, atau png',
        ]);

        // Upload file dengan nama yang unik
        $fotoKtp = $request->file('foto_ktp')->store('ktp', 'public');
        $fotoSelfi = $request->file('foto_selfi')->store('selfie', 'public');

        // Simpan data kunjungan
        Visit::create([
            'id_pelanggan' => $request->id_pelanggan,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'tujuan' => $request->tujuan,
            'petugas' => $request->petugas,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk ?? date('H:i:s'),
            'jam_keluar' => $request->jam_keluar,
            'foto_ktp' => $fotoKtp,
            'foto_selfi' => $fotoSelfi,
            'status' => 'menunggu',
        ]);

        return redirect()->route('kunjungan.index')
            ->with('success', 'Data kunjungan berhasil ditambahkan');
    }

    /**
     * Menampilkan detail kunjungan
     */
    public function show($id)
    {
        if (!Session::get('petugas_login')) {
            return redirect('/login-petugas');
        }

        $kunjungan = Visit::findOrFail($id);
        return view('kunjungan.show', compact('kunjungan'));
    }

    /**
     * Menampilkan form edit kunjungan
     */
    public function edit($id)
    {
        if (!Session::get('petugas_login')) {
            return redirect('/login-petugas');
        }

        $kunjungan = Visit::findOrFail($id);
        return view('kunjungan.edit', compact('kunjungan'));
    }

    /**
     * Mengupdate data kunjungan
     */
    public function update(Request $request, $id)
    {
        if (!Session::get('petugas_login')) {
            return redirect('/login-petugas');
        }

        $kunjungan = Visit::findOrFail($id);

        $request->validate([
            'no_hp' => 'required',
            'tujuan' => 'required',
            'petugas' => 'required',
            'jam_keluar' => 'nullable',
        ]);

        $kunjungan->update([
            'no_hp' => $request->no_hp,
            'tujuan' => $request->tujuan,
            'petugas' => $request->petugas,
            'jam_keluar' => $request->jam_keluar,
        ]);

        return redirect()->route('kunjungan.index')
            ->with('success', 'Data kunjungan berhasil diperbarui');
    }

    /**
     * Menghapus data kunjungan
     */
    public function destroy($id)
    {
        if (!Session::get('petugas_login')) {
            return redirect('/login-petugas');
        }

        $kunjungan = Visit::findOrFail($id);

        // Hapus file foto
        if ($kunjungan->foto_ktp) {
            Storage::disk('public')->delete($kunjungan->foto_ktp);
        }
        if ($kunjungan->foto_selfi) {
            Storage::disk('public')->delete($kunjungan->foto_selfi);
        }

        $kunjungan->delete();

        return redirect()->route('kunjungan.index')
            ->with('success', 'Data kunjungan berhasil dihapus');
    }

    /**
     * Menandai kunjungan selesai
     */
    public function selesai($id)
    {
        // proteksi session
        if (!Session::get('petugas_login')) {
            return redirect('/login-petugas');
        }

        $kunjungan = Visit::findOrFail($id);

        $kunjungan->update([
            'status' => 'Selesai',
            'jam_keluar' => now()->format('H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Kunjungan selesai');
    }

    // API untuk realtime
    public function realtime()
    {
        // proteksi session (opsional untuk API)
        if (!Session::get('petugas_login')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = DB::table('kunjungan')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($data);
    }
}
