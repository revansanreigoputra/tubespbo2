<?php

namespace App\Http\Controllers\Api\Handlers;

use App\Http\Resources\PesananResource;
use Illuminate\Support\Facades\DB;

class PesananDestroyHandler
{
    public function handle($id)
    {
        try {
            $pdo = DB::connection()->getPdo();

            // Cek apakah pesanan ada
            $pesanan = $pdo->query("SELECT * FROM pesanans WHERE id = $id")->fetch(\PDO::FETCH_ASSOC);
            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            // Hapus pesanan
            $sql = "DELETE FROM pesanans WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            return new PesananResource(true, 'Data Pesanan Berhasil Dihapus!', null);
        } catch (\PDOException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
