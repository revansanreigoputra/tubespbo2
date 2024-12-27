<?php

namespace App\Http\Controllers\Api;

use App\Models\Pelanggan;
use App\Http\Controllers\Controller;
use App\Http\Resources\PelangganResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // Ambil data pelanggan
        $pelanggans = Pelanggan::latest()->paginate(5);

        // Kembalikan resource pelanggan
        return new PelangganResource(true, 'List Data Pelanggan', $pelanggans);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        // Tentukan aturan validasi
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'email'     => 'required|email',
            'no_telepon' => 'required',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Buat data pelanggan baru
        $pelanggan = Pelanggan::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        // Kembalikan response dengan data pelanggan yang baru ditambahkan
        return new PelangganResource(true, 'Data Pelanggan Berhasil Ditambahkan!', $pelanggan);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        // Cari pelanggan berdasarkan ID
        $pelanggan = Pelanggan::find($id);

        // Jika pelanggan tidak ditemukan
        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
        }

        // Kembalikan data pelanggan sebagai resource
        return new PelangganResource(true, 'Detail Data Pelanggan', $pelanggan);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Tentukan aturan validasi
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'email'     => 'required|email',
            'no_telepon' => 'required',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cari pelanggan berdasarkan ID
        $pelanggan = Pelanggan::find($id);

        // Jika pelanggan tidak ditemukan
        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
        }

        // Perbarui data pelanggan
        $pelanggan->update([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        // Kembalikan response dengan data pelanggan yang telah diperbarui
        return new PelangganResource(true, 'Data Pelanggan Berhasil Diubah!', $pelanggan);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        // Cari pelanggan berdasarkan ID
        $pelanggan = Pelanggan::find($id);

        // Jika pelanggan tidak ditemukan
        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan'], 404);
        }

        // Hapus pelanggan
        $pelanggan->delete();

        // Kembalikan response
        return new PelangganResource(true, 'Data Pelanggan Berhasil Dihapus!', null);
    }
}
