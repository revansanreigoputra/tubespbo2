<?php

namespace App\Http\Controllers\Api\Handlers;

use App\Http\Resources\PesananResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PesananUpdateHandler
{
    public function handle(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_tiket' => 'required|integer',
            'total_harga'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $pdo = DB::connection()->getPdo();

            // Cek apakah pesanan ada
            $pesanan = $pdo->query("SELECT * FROM pesanans WHERE id = $id")->fetch(\PDO::FETCH_ASSOC);
            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            // Update data pesanan
            $sql = "UPDATE pesanans 
                    SET jumlah_tiket = :jumlah_tiket, total_harga = :total_harga, updated_at = :updated_at 
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':jumlah_tiket' => $request->jumlah_tiket,
                ':total_harga'  => $request->total_harga,
                ':updated_at'   => now(),
                ':id'           => $id,
            ]);

            // Ambil data pesanan terbaru
            $pesanan = $pdo->query("SELECT * FROM pesanans WHERE id = $id")->fetch(\PDO::FETCH_ASSOC);

            return new PesananResource(true, 'Data Pesanan Berhasil Diubah!', $pesanan);
        } catch (\PDOException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
