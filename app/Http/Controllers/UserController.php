<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function getUsers(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $query->with('roles')->paginate(5);

        return response()->json($users);
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $role = Role::find($validatedData['role_id']);

        if ($role) {
            $user->assignRole($role->name);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        $user->roles()->detach();

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
        ]);

        if (isset($validatedData['role_id'])) {
            $role = Role::find($validatedData['role_id']);
            if ($role) {
                $user->assignRole($role->name);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function resetPassword(User $user)
    {
        try {
            $role = $user->roles->first();
            $roleName = $role ? $role->name : 'default';
            $newPassword = $roleName;

            $user->password = bcrypt($newPassword);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset ke: ' . $newPassword,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset password.',
            ], 500);
        }
    }

    public function destroy(User $user) 
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
