<?php

// app/Http/Controllers/Api/PesananController.php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Http\Resources\PesananResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    public function index()
    {
        try {
            $pesanans = Pesanan::latest()->paginate(5);
            return new PesananResource(true, 'List Data Pesanan', $pesanans);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_pelanggan' => 'required|exists:pelanggans,id',
                'jumlah_tiket' => 'required|integer',
                'total_harga'  => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $pesanan = Pesanan::create([
                'id_pelanggan' => $request->id_pelanggan,
                'jumlah_tiket' => $request->jumlah_tiket,
                'total_harga'  => $request->total_harga,
            ]);

            return new PesananResource(true, 'Data Pesanan Berhasil Ditambahkan!', $pesanan);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $pesanan = Pesanan::find($id);
            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }
            return new PesananResource(true, 'Detail Data Pesanan', $pesanan);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_pelanggan' => 'required|exists:pelanggans,id',
                'jumlah_tiket' => 'required|integer',
                'total_harga'  => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $pesanan = Pesanan::find($id);
            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            $pesanan->update([
                'id_pelanggan' => $request->id_pelanggan,
                'jumlah_tiket' => $request->jumlah_tiket,
                'total_harga'  => $request->total_harga,
            ]);

            return new PesananResource(true, 'Data Pesanan Berhasil Diubah!', $pesanan);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pesanan = Pesanan::find($id);
            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            $pesanan->delete();

            return new PesananResource(true, 'Data Pesanan Berhasil Dihapus!', null);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
