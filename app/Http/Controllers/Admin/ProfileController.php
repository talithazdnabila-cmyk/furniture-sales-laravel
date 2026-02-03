<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function destroy()
{
    $user = Auth::user();

    if ($user->photo && file_exists(public_path('admin_photo/' . $user->photo))) {
        unlink(public_path('admin_photo/' . $user->photo));
    }

    $user->photo = null;
    $user->save();

    return back()->with('success', 'Foto profil berhasil dihapus');
}


    public function update(Request $request)
    {
        $request->validate([
        'name'  => 'required',
        'email' => 'required|email',
        'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $user = Auth::user();

    $user->name  = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('photo')) {

    if ($user->photo && file_exists(public_path('admin_photo/' . $user->photo))) {
        unlink(public_path('admin_photo/' . $user->photo));
    }

    $file = $request->file('photo');
    $filename = time() . '.' . $file->extension();

    $file->move(public_path('admin_photo'), $filename);

    $user->photo = $filename;
}


    $user->save();

    return back()->with('success', 'Profile berhasil diupdate');
    }
}
