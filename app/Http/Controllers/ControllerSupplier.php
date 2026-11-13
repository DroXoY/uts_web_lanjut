<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ControllerSupplier extends Controller
{
    // Menampilkan halaman utama daftar supplier
    public function index(Request $request)
    {
        $supplier = DB::table('supplier')->get();
        return view('Supplier.index', ['supplier' => $supplier]);
    }

    // Menampilkan halaman create (ganti blade)
    public function create()
    {
        return view('Supplier.create');
    }

    // CREATE: Menyimpan data baru via AJAX
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode'       => 'required|unique:supplier,kode|max:5',
            'nama'       => 'required|string|max:50',
            'alamat'     => 'required|string|max:100',
            'telp'       => 'required|string|max:15',
            'perusahaan' => 'required|string|max:50',
            'keterangan' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::table('supplier')->insert([
            'kode'       => $request->kode,
            'nama'       => $request->nama,
            'alamat'     => $request->alamat,
            'telp'       => $request->telp,
            'perusahaan' => $request->perusahaan,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Supplier berhasil ditambahkan!'
        ]);
    }

    // Menampilkan form edit (ganti blade)
    public function edit(string $kode)
    {
        $supplier = DB::table('supplier')->where('kode', $kode)->first();
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data tidak ditemukan');
        }

        return view('Supplier.edit', ['supplier' => $supplier]);
    }

    // UPDATE: Memperbarui data via AJAX (kode diambil dari $request->kode)
    public function update(Request $request)
    {
        $kode = $request->kode;
        $validator = Validator::make($request->all(), [
            'kode'       => 'required|max:5',
            'nama'       => 'required|string|max:50',
            'alamat'     => 'required|string|max:100',
            'telp'       => 'required|string|max:15',
            'perusahaan' => 'required|string|max:50',
            'keterangan' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::table('supplier')->where('kode', $kode)->update([
            'nama'       => $request->nama,
            'alamat'     => $request->alamat,
            'telp'       => $request->telp,
            'perusahaan' => $request->perusahaan,
            'keterangan' => $request->keterangan,
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Supplier berhasil diperbarui!'
        ]);
    }

    // DELETE: Menghapus data via AJAX (kode diambil dari $request->kode)
    public function destroy(Request $request)
    {
        $kode = $request->kode;
        DB::table('supplier')->where('kode', $kode)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Supplier berhasil dihapus!'
        ]);
    }
}
