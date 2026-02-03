<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'role' => $request->role
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Role user berhasil diubah');
    }

    public function destroy($id)
{
    $user = \App\Models\User::findOrFail($id);

    // optional: cegah hapus diri sendiri
    if ($user->id === auth()->id()) {
        return back()->with('error', 'Tidak bisa menghapus akun sendiri');
    }

    $user->delete();

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User berhasil dihapus');
}
}
