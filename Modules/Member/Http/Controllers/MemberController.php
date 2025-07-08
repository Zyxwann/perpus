<?php

namespace Modules\Member\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Member\Entities\Member;
use Modules\Member\Http\Requests\StoreMemberRequest;

class MemberController extends Controller
{
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
        Member::create($request->validated());
        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('member::edit', compact('member'));
    }

    public function update(StoreMemberRequest $request, Member $member)
    {
        $member->update($request->validated());
        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }
}
