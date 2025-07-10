<?php

namespace Modules\Buku\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Buku\Entities\Buku;
use GuzzleHttp\Client;

class BukuController extends Controller
{
    public function listBukuForMember()
    {
        $buku = Buku::all();
        return view('member::data_buku', compact('buku'));
    }

    public function index()
    {
        $buku = Buku::all();
        return view('buku::index', compact('buku'));
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku::show', compact('buku'));
    }

    public function create()
    {
        return view('buku::create');
    }

    public function store(Request $request)
    {
        if (!file_exists(public_path('uploads/foto_buku'))) {
            mkdir(public_path('uploads/foto_buku'), 0755, true);
        }

        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|digits:4|integer',
            'isbn' => 'required|unique:bukus',
            'jumlah' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['judul', 'penulis', 'penerbit', 'tahun_terbit', 'isbn', 'jumlah']);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto_buku'), $filename);
            $data['foto'] = $filename;
        }

        Buku::create($data);
        return redirect()->route('buku.index')->with('success', 'Buku ditambahkan!');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku::edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        if (!file_exists(public_path('uploads/foto_buku'))) {
            mkdir(public_path('uploads/foto_buku'), 0755, true);
        }

        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|digits:4|integer',
            'isbn' => 'required|unique:bukus,isbn,' . $id,
            'jumlah' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['judul', 'penulis', 'penerbit', 'tahun_terbit', 'isbn', 'jumlah']);

        if ($request->hasFile('foto')) {
            if ($buku->foto && file_exists(public_path('uploads/foto_buku/' . $buku->foto))) {
                unlink(public_path('uploads/foto_buku/' . $buku->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto_buku'), $filename);
            $data['foto'] = $filename;
        }

        $buku->update($data);
        return redirect()->route('buku.index')->with('success', 'Buku diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->foto && file_exists(public_path('uploads/foto_buku/' . $buku->foto))) {
            unlink(public_path('uploads/foto_buku/' . $buku->foto));
        }

        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku dihapus!');
    }

    // ✅ Tambahan: CONSUME API eksternal pakai Guzzle
    public function fetchExternalBooks()
    {
        $client = new Client();
        
        try {
            $response = $client->get(env('APP_API_URL' ).'/api/buku'); 
            $data = json_decode($response->getBody(), true);
            dd($data);

            $books = collect($data['docs'])->take(10)->map(function ($item) {
                return [
                    'judul' => $item['title'] ?? '-',
                    'penulis' => $item['author_name'][0] ?? '-',
                    'penerbit' => $item['publisher'][0] ?? '-',
                    'tahun_terbit' => $item['first_publish_year'] ?? '-',
                    'isbn' => $item['isbn'][0] ?? 'N/A',
                    'foto' => $item['foto'] ?? '' 
                ];
            });

            return view('buku::external_books', compact('books'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data buku eksternal: ' . $e->getMessage());
        }
    }
}
