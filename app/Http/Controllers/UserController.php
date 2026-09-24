<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\PermissionEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
   public function index() {

    // Spatie mendaftarkan permission ke Gate secara otomatis
    Gate::authorize(PermissionEnum::VIEW_USERS->value);

    $users = User::with('roles')->latest()->get();
    return view('users.index', compact('users'));

   }

   public function create() {
    Gate::authorize(PermissionEnum::CREATE_USERS->value);

    // ambil semua daftar role untuk ditampilkan di dropdown form
    $roles = Role::all();
    return view('users.create', compact('roles'));

   }

   public function store(Request $request) {

    Gate::authorize(PermissionEnum::CREATE_USERS->value);

    $request->validate([
     'name' => ['required', 'string', 'max:255'],
     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
     'password' => ['required', 'confirmed', Password::defaults()],
     'role'=> ['required', 'exists:roles,name']
    ]);


    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // berikan role yang dipilih admin ke user baru tersebut
    $user->assignRole($request->role);

    return redirect()->route('users.index')->with(['success' => 'Data berhasil ditambahkan']);
   }

   public function edit(User $user) {
    Gate::authorize(PermissionEnum::EDIT_USERS->value);

    $roles = Role::all();
    return view('users.edit', compact('user','roles'));
   }

   public function update(Request $request, User $user) {
    Gate::authorize(PermissionEnum::EDIT_USERS->value);

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
        'role' => ['required', 'exists:roles,name'],
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // jika admin mengisi kolom password, update passwordnya
    if ($request->filled('password')){
        $request->validate(['password' => ['confirmed', Password::defaults()]]);
        $user->update(['password' => Hash::make($request->password)]);
    }

    // Sinkronisasi ulang role (mencabut role lama dan mengganti dengan yang baru)
    $user->syncRoles([$request->role]);

    return redirect()->route('users.index')->with(['success' => 'User berhasil diperbarui']);

   }

   public function destroy(User $user) {
    Gate::authorize(PermissionEnum::DELETE_USERS->value);

    // Keamanan tambahan: Cegah admin menghapus akunnya sendiri
    if (auth()->id() === $user->id) {
        return back()->with(['error' => 'Anda tidak bisa menghapus akun anda sendiri']);
    }

    $user->delete();
    return redirect()->route('users.index')->with(['success' => 'User berhasil dihapus']);

   }


}
