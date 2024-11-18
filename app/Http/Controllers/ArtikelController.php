<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArtikelModel;

class ArtikelController extends Controller
{
    /**
     * Store a new artikel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            $artikel = ArtikelModel::create([
                'judul' => $request->input('judul'),
                'penulis' => $request->input('penulis'),
                'deskripsi' => $request->input('deskripsi'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil disimpan',
                'data' => $artikel,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan artikel',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $this->validate($request, [
            'judul' => 'string|max:255',
            'penulis' => 'string|max:255',
            'deskripsi' => 'string',
        ]);

        try {
            // Cari artikel berdasarkan ID
            $artikel = ArtikelModel::findOrFail($id);

            // Ambil input yang diperbarui
            $input = $request->only(['judul', 'penulis', 'deskripsi']);

            // Perbarui hanya jika ada perubahan
            $artikel->fill($input);
            if ($artikel->isDirty()) {
                $artikel->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Artikel berhasil diperbarui',
                    'data' => $artikel,
                ], 200);
            }

            // Jika tidak ada perubahan
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada perubahan pada data artikel',
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui artikel',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     \Log::info('Request data:', $request->all());  // Log the received data

    //     // Validasi data yang diterima
    //     $this->validate($request, [
    //         'judul' => 'required|string|max:255',
    //         'penulis' => 'required|string|max:255',
    //         'deskripsi' => 'nullable|string',
    //     ]);

    //     try {
    //         // Cari artikel berdasarkan ID
    //         $artikel = ArtikelModel::findOrFail($id);

    //         // Ambil input yang diperbarui
    //         $input = $request->only(['judul', 'penulis', 'deskripsi']);

    //         // Perbarui hanya jika ada perubahan
    //         $artikel->fill($input);
    //         if ($artikel->isDirty()) {
    //             $artikel->save();
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Artikel berhasil diperbarui',
    //                 'data' => $artikel,
    //             ], 200);
    //         }

    //         // Jika tidak ada perubahan
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Tidak ada perubahan pada data artikel',
    //         ], 200);

    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Artikel tidak ditemukan',
    //         ], 404);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Terjadi kesalahan saat memperbarui artikel',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }


    public function destroy($id)
    {
        try {
            // Cari artikel berdasarkan ID
            $artikel = ArtikelModel::findOrFail($id);

            // Hapus artikel
            $artikel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil dihapus',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus artikel',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}

