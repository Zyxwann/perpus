<?php

namespace Modules\Buku\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Buku\Entities\Buku;

class BukuApiController extends Controller
{
    public function index()
    {
        return response()->json(Buku::all());
    }
    

    public function store(Request $request)
    {
         if (!file_exists(public_path('uploads/foto_buku'))) {
            mkdir(public_path('uploads/foto_buku'), 0755, true);
        }
        $validate = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|digits:4|integer',
            'isbn' => 'required|unique:bukus',
            'jumlah' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $buku = Buku::create($request->all());
        return response()->json([
            'message' => 'Buku created successfully',
            'data' => $buku,
        ]
        );
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return response()->json($buku);
    }

    public function update(Request $request, $id)
    {

         if (!file_exists(public_path('uploads/foto_buku'))) {
            mkdir(public_path('uploads/foto_buku'), 0755, true);
        }
        $buku = Buku::findOrFail($id);

                $validate = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|digits:4|integer',
            'isbn' => 'required|unique:bukus',
            'jumlah' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $buku->update($request->all());

        return response()->json([
            'message' => 'Buku updated successfully',
            'data' => $buku
        ]);
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        Buku::destroy($id);
        return response()->json([
            'message' => 'Member deleted successfully'
        ]);
    }
}
