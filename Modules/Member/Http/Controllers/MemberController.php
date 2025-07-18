<?php

namespace Modules\Member\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Member\Entities\Member;
use Modules\Member\Http\Requests\StoreMemberRequest;

class MemberController extends Controller
{
    protected string $apiUrl;
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = rtrim(config('app.api_url'), '/') . '/api/members';
    }
    


    // ========== CONSUME API ==========

    public function getMembersFromApi()
    {
        try {
            $response = $this->client->request('GET', $this->apiUrl, ['timeout' => 5]);

            // PENTING: pastikan JSON diparse sebagai array
            $data = json_decode($response->getBody()->getContents(), true);
            


            // Kirim ke view
            return view('member::data_api', compact('data'));
        } catch (\Exception $e) {
            return view('member::data_api')->with([
                'data' => [],
                'error' => 'Gagal muat data: ' . $e->getMessage(),
            ]);
        }
    }




    public function createMemberApi(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'telepon' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $multipart = [
            ['name' => 'nama', 'contents' => $request->nama],
            ['name' => 'email', 'contents' => $request->email],
            ['name' => 'alamat', 'contents' => $request->alamat],
            ['name' => 'telepon', 'contents' => $request->telepon],
        ];

        if ($request->hasFile('foto')) {
            $multipart[] = [
                'name' => 'foto',
                'contents' => fopen($request->file('foto')->getPathname(), 'r'),
                'filename' => $request->file('foto')->getClientOriginalName(),
            ];
        }

        try {
            $this->client->request('POST', $this->apiUrl, ['multipart' => $multipart]);
            return redirect()->route('member.api.index')->with('success', 'Member berhasil ditambahkan lewat API');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal kirim ke API: ' . $e->getMessage());
        }
    }

    public function editMemberApi($id)
    {
        $response = $this->client->request('GET', "{$this->apiUrl}/{$id}");
        $member = json_decode($response->getBody()->getContents(), true);

        return view('member::edit_api', compact('member'));
    }

    public function updateMemberApi(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Build multipart form data
        $multipart = [
            ['name' => '_method', 'contents' => 'PUT'], // override method
            ['name' => 'nama', 'contents' => $request->nama],
            ['name' => 'email', 'contents' => $request->email],
            ['name' => 'alamat', 'contents' => $request->alamat],
            ['name' => 'telepon', 'contents' => $request->telepon],
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $multipart[] = [
                'name' => 'foto',
                'contents' => fopen($foto->getPathname(), 'r'),
                'filename' => $foto->getClientOriginalName(),
            ];
        }

        try {
            $this->client->request('POST', "{$this->apiUrl}/{$id}", [
                'multipart' => $multipart,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            return redirect()->route('member.api.index')->with('success', 'Member diperbarui lewat API');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update ke API: ' . $e->getMessage());
        }
    }


    public function deleteMemberApi($id)
    {
        try {
            $this->client->request('DELETE', "{$this->apiUrl}/{$id}");
            return redirect()->back()->with('success', 'Member dihapus lewat API');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus member: ' . $e->getMessage());
        }
    }

    // ========== LOCAL CRUD (Langsung DB) ==========

    public function index(Request $request)
    {
        $search = $request->input('search');

        $members = Member::when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->orderBy('id', 'desc')->paginate(10);
        
        

        return view('member::index', compact('members', 'search'));
    }

    public function create()
    {
        return view('member::create');
    }

    public function store(StoreMemberRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-member', 'public');
        }

        Member::create($data);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan');
    }

    public function edit(Member $member)
    {
        return view('member::edit', compact('member'));
    }

    public function update(StoreMemberRequest $request, Member $member)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            if ($member->foto && Storage::disk('public')->exists($member->foto)) {
                Storage::disk('public')->delete($member->foto);
            }

            $validated['foto'] = $request->file('foto')->store('foto-member', 'public');
        }

        $member->update($validated);

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->foto && Storage::disk('public')->exists($member->foto)) {
            Storage::disk('public')->delete($member->foto);
        }

        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }
}
