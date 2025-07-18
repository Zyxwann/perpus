<?php

namespace Modules\Buku\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
            $response = $client->get(env('APP_API_URL') . '/api/v1/bukus');
            $data = json_decode($response->getBody(), true);

            if (!is_array($data)) {
                return back()->with('error', 'Data dari API tidak valid');
            }

            $books = collect($data)->map(function ($item) {
                $foto_url = null;
                if (!empty($item['foto'])) {
                    $baseUrl = rtrim(env('APP_API_URL'), '/');
                    $foto_url = $baseUrl . '/uploads/foto_buku/' . $item['foto'];
                }
                return [
                    'id'          => $item['id'] ?? null,
                    'judul'       => $item['judul'] ?? '-',
                    'penulis'     => $item['penulis'] ?? '-',
                    'penerbit'    => $item['penerbit'] ?? '-',
                    'tahun_terbit'=> $item['tahun_terbit'] ?? '-',
                    'isbn'        => $item['isbn'] ?? 'N/A',
                    'jumlah'      => $item['jumlah'] ?? 0,
                    'foto'        => $item['foto'] ?? '',
                    'foto_url'    => $foto_url,
                ];
            });

            return view('buku::external', ['books' => $books]);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data buku eksternal: ' . $e->getMessage());
        }
    }

    public function createExternal(Request $request)
    {
        $request->validate([
            'judul'         => 'required',
            'penulis'       => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required|digits:4|integer',
            'isbn'          => 'required|unique:bukus',
            'jumlah'        => 'required|integer',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $multipart = [
            ['name' => 'judul',        'contents' => $request->judul],
            ['name' => 'penulis',      'contents' => $request->penulis],
            ['name' => 'penerbit',     'contents' => $request->penerbit],
            ['name' => 'tahun_terbit', 'contents' => $request->tahun_terbit],
            ['name' => 'isbn',         'contents' => $request->isbn],
            ['name' => 'jumlah',       'contents' => $request->jumlah],
        ];

        if ($request->hasFile('foto')) {
            $multipart[] = [
                'name'     => 'foto',
                'contents' => fopen($request->file('foto')->getRealPath(), 'r'),
                'filename' => $request->file('foto')->getClientOriginalName(),
            ];
        }

        try {
            $client = new Client();
            $client->request('POST', env('APP_API_URL') . '/api/v1/bukus', [
                'multipart' => $multipart,
                'timeout'   => 10,
            ]);

            return redirect()
                ->route('buku.external')
                ->with('success', 'Buku eksternal ditambahkan!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menambahkan buku eksternal: ' . $e->getMessage());
        }
    }
public function editExternal($id)
{
    $client  = new Client();
    $baseUrl = rtrim(env('APP_API_URL'), '/');

    try {
        $res   = $client->get($baseUrl . '/api/v1/bukus/' . $id);
        $data  = json_decode($res->getBody(), true);

        if (!$data || !isset($data['id'])) {
            return redirect()->route('buku.external')
                             ->with('error', 'Data buku tidak ditemukan.');
        }

        $data['foto_url'] = !empty($data['foto'])
            ? $baseUrl . '/uploads/foto_buku/' . $data['foto']
            : null;

        return view('buku::edit_external', ['book' => $data]);

    } catch (\Throwable $e) {
        \Log::error('Gagal ambil buku eksternal: ' . $e->getMessage());
        return redirect()->route('buku.external')
                         ->with('error', 'Gagal mengambil data buku.');
    }
}

 public function updateExternal(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul'        => 'required',
            'penulis'      => 'required',
            'penerbit'     => 'required',
            'tahun_terbit' => 'required|digits:4|integer',
            'jumlah'       => 'required|integer|min:1',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'isbn'         => ['required', 'string', Rule::unique('bukus', 'isbn')->ignore($id)],
        ]);

        try {
            $client = new Client();

            if ($request->hasFile('foto')) {
                // Kalau ada file, kirim multipart
                $multipart = [
                    ['name' => 'judul',        'contents' => $request->judul],
                    ['name' => 'penulis',      'contents' => $request->penulis],
                    ['name' => 'penerbit',     'contents' => $request->penerbit],
                    ['name' => 'tahun_terbit', 'contents' => $request->tahun_terbit],
                    ['name' => 'jumlah',       'contents' => $request->jumlah],
                    ['name' => 'isbn',         'contents' => $request->isbn],
                    ['name' => 'foto',         'contents' => fopen($request->file('foto')->getRealPath(), 'r'), 'filename' => $request->file('foto')->getClientOriginalName()],
                ];

                \Log::info('Update buku eksternal multipart data:', $multipart);

                $response = $client->request('PUT', rtrim(env('APP_API_URL'), '/') . "/api/v1/bukus/{$id}", [
                    'multipart' => $multipart,
                    'timeout' => 10,
                    'headers' => ['Accept' => 'application/json'],
                ]);
            } else {
                // Kalau tidak ada file, kirim form_params (x-www-form-urlencoded)
                $formParams = [
                    'judul'        => $request->judul,
                    'penulis'      => $request->penulis,
                    'penerbit'     => $request->penerbit,
                    'tahun_terbit' => $request->tahun_terbit,
                    'jumlah'       => $request->jumlah,
                    'isbn'         => $request->isbn,
                ];

                \Log::info('Update buku eksternal form_params data:', $formParams);

                $response = $client->request('PUT', rtrim(env('APP_API_URL'), '/') . "/api/v1/bukus/{$id}", [
                    'form_params' => $formParams,
                    'timeout' => 10,
                    'headers' => ['Accept' => 'application/json'],
                ]);
            }

            $status = $response->getStatusCode();
            \Log::info('Update buku eksternal, status: ' . $status);

            if (in_array($status, [200, 201, 204])) {
                return redirect()->route('buku.external')
                                 ->with('success', 'Buku eksternal berhasil diperbarui!');
            }

            return back()->with('error', 'Update gagal. Status API: ' . $status);

        } catch (\Throwable $e) {
            \Log::error('Gagal update buku eksternal: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui buku: ' . $e->getMessage());
        }
    }
  public function deleteExternal($id)
{
    $client = new Client();
    $baseUrl = rtrim(env('APP_API_URL'), '/');

    try {
        $client->request('DELETE', $baseUrl . '/api/v1/bukus/' . $id, [
            'timeout' => 10,
        ]);

        // Debug URL
        // dd(route('buku.external'));

        return redirect()->route('buku.external')
                         ->with('success', 'Buku eksternal berhasil dihapus!');
    } catch (\Throwable $e) {
        return redirect()->route('buku.external')
                         ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
    }
}


}
