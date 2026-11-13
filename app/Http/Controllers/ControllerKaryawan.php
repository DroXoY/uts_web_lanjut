<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ControllerKaryawan extends Controller
{
    // Menampilkan halaman utama daftar karyawan
    public function index(Request $request)
    {
        $karyawan = DB::table('karyawan')->get();
        return view('Karyawan.index', ['karyawan' => $karyawan]);
    }

    // Menampilkan halaman create (ganti blade)
    public function create()
    {
        return view('Karyawan.create');
    }

    // CREATE: Menyimpan data baru via AJAX
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode'          => 'required|unique:karyawan,kode|max:5',
            'nama'          => 'required|string|max:50',
            'alamat'        => 'required|string|max:100',
            'telp'          => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'pendidikan'    => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::table('karyawan')->insert([
            'kode'          => $request->kode,
            'nama'          => $request->nama,
            'alamat'        => $request->alamat,
            'telp'          => $request->telp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'pendidikan'    => $request->pendidikan,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Karyawan berhasil ditambahkan!'
        ]);
    }

    // Menampilkan form edit (ganti blade)
    public function edit(string $kode)
    {
        $karyawan = DB::table('karyawan')->where('kode', $kode)->first();
        if (!$karyawan) {
            return redirect('/karyawan')->with('error', 'Data tidak ditemukan');
        }

        return view('Karyawan.edit', ['karyawan' => $karyawan]);
    }

    // UPDATE: Memperbarui data via AJAX (kode diambil dari $request->kode)
    public function update(Request $request)
    {
        $kode = $request->kode;
        $validator = Validator::make($request->all(), [
            'kode'          => 'required|max:5',
            'nama'          => 'required|string|max:50',
            'alamat'        => 'required|string|max:100',
            'telp'          => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'pendidikan'    => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::table('karyawan')->where('kode', $kode)->update([
            'nama'          => $request->nama,
            'alamat'        => $request->alamat,
            'telp'          => $request->telp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'pendidikan'    => $request->pendidikan,
            'updated_at'    => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Karyawan berhasil diperbarui!'
        ]);
    }

    // DELETE: Menghapus data via AJAX (kode diambil dari $request->kode)
    public function destroy(Request $request)
    {
        $kode = $request->kode;
        DB::table('karyawan')->where('kode', $kode)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Karyawan berhasil dihapus!'
        ]);
    }
}
