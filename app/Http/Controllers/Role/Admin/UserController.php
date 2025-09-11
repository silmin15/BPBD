<?php

namespace App\Http\Controllers\Role\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // LIST SEMUA USER (tanpa filter role)
    public function index(Request $r)
    {
        $q = User::query();

        if ($term = $r->get('q')) {
            $q->where(function ($w) use ($term) {
                $w->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('username', 'like', "%{$term}%");
            });
        }

        $usersers = $q->orderBy('name')->paginate(10)->withQueryString();
        $roles = Role::pluck('name', 'id'); // <-- kirim ke view

        return view('role.admin.manajemen-user.index', [
            'users'   => $usersers,
            'roles'   => $roles,   // <-- penting
            'role'    => null,
            'editing' => false,
        ]);
    }

    // LIST USER BERDASARKAN ROLE (PK/KL/RR/Staf BPBD)
    public function byRole(string $role, Request $r)
    {
        abort_unless(in_array($role, ['PK', 'KL', 'RR', 'Staf BPBD']), 404);

        $q = User::role($role);

        if ($term = $r->get('q')) {
            $q->where(function ($w) use ($term) {
                $w->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('username', 'like', "%{$term}%");
            });
        }

        $usersers = $q->orderBy('name')->paginate(10)->withQueryString();
        $roles = Role::pluck('name', 'id'); // <-- juga kirim di halaman filter

        return view('role.admin.manajemen-user.index', [
            'users'   => $usersers,
            'roles'   => $roles,   // <-- penting
            'role'    => $role,
            'editing' => false,
        ]);
    }

    // (masih ada rute create terpisah kalau mau dipakai)
    public function create(Request $r)
    {
        $role = $r->get('role');
        return view('role.admin.manajemen-user.create', compact('role'));
    }

    public function store(Request $r)
    {
        $data = $r->validateWithBag('createUser', [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'username'  => 'nullable|string|unique:users,username',
            'phone'     => 'nullable|string',
            'role'      => 'required|in:PK,KL,RR,Staf BPBD',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'username'          => $data['username'] ?? null,
            'phone'             => $data['phone'] ?? null,
            'password'          => Hash::make($data['password']),
            'email_verified_at' => now(), // <-- langsung terverifikasi
        ]);

        $user->assignRole($data['role']);

        $redirectRole = $r->input('redirect_role');
        return $redirectRole
            ? redirect()->route('admin.manajemen-user.byrole', $redirectRole)->with('success', 'User dibuat dan aktif.')
            : back()->with('success', 'User dibuat dan aktif.');
    }


    public function edit(User $userser)
    {
        return view('role.admin.manajemen-user.edit', [
            'user'    => $userser,
            'role'    => $userser->getRoleNames()->first(),
            'editing' => true,
        ]);
    }

    public function update(Request $r, User $userser)
    {
        $r->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $userser->id,
            'username' => 'nullable|string|unique:users,username,' . $userser->id,
            'phone'    => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed', // selaras dengan form jika dipakai
            'role'     => 'required|in:PK,KL,RR,Staf BPBD',
        ]);

        $data = $r->only('name', 'email', 'username', 'phone');

        if ($r->filled('password')) {
            $data['password'] = Hash::make($r->password);
        }

        $userser->update($data);
        $userser->syncRoles([$r->role]);

        return redirect()
            ->route('role.admin.manajemen-user.byrole', $r->role)
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $userser)
    {
        // Cegah hapus akun sendiri
        if (Auth::check() && Auth::id() === $userser->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $userser->delete();

        return back()->with('success', 'User dihapus.');
    }
}
