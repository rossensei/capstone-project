<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->input('role');
        $search = $request->input('search');
        $status = $request->input('status');
        $perPage = $request->input('perPage') ?? 5;

        $userQuery = User::query();

        $userQuery->orderBy('name')->with('roles');

        if($role) {
            $userQuery->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });
        }

        if($search) {
            $userQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if($status && $status == 'active') {
            $userQuery->where('active', true);
        } else if($status && $status == 'inactive') {
            $userQuery->where('active', false);
        }
        
        $users = $userQuery->paginate($perPage)
            ->onEachSide(0)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'address' => $user->address,
                'active' => $user->active,
                'role' => $user->getUserRole(),
                'profile_photo_url' => $user->profile_photo_url,
                'created_at' => $user->created_at,
            ]);

        return inertia('User/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'role', 'status', 'perPage']),
            'roles' => Role::all()
        ]);
    }

    public function create()
    {
        return inertia('User/Create', [
            'roles' => Role::all()
        ]);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required'],
        ]);

        $role = $fields['role'];
        unset($fields['role']);

        $user = User::create($fields);

        $user->assignRole($role);

        return redirect('/admin/users')->with('success', 'User has been created.');
    }

    public function edit(User $user)
    {
        $userWithRole = [
            'id' => $user->id,
            'username' => $user->username,
            'address' => $user->address,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->getUserRole(),
        ];

        return inertia('User/Edit', [
            'user' => $userWithRole,
            'roles' => Role::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'username' => ['string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'role' => ['required'],
        ]);

        $role = $fields['role'];
        unset($fields['role']);

        $user->syncRoles($role);

        $user->update($fields);

        return back()->with('success', 'User details has been updated.');
    }

    public function updateUserLogon(Request $request, User $user)
    {
        $attr = $request->validate([
            'username' => ['required', 'string', 'max:16'],
            'password' => ['confirmed', 'min:8', 'required']
        ]);

        // $user->password = $request->password;
        // $user->save();
        $user->update($attr);

        return back()->with('success', 'User logon details has been updated.');
    }

    public function destroy(User $user)
    {
        if($user->office()->exists()) {
            // dd(true);
            return back()->with('error', 'User cannot be deleted. This user might be handling an office at this moment.');
        }
        $user->delete();

        return back()->with('success', 'User has been removed.');
    }

    public function updateRole(Request $request, User $user)
    {
        $oldRole = $user->getRoleNames();

        foreach($oldRole as $o){
            $user->removeRole($o);
        }

        $user->assignRole($request->role);

        return back();
    }

    public function toggleActive(User $user)
    {
        $user->active = !$user->active;
        $user->save();
        
        if($user->active) {
            return back()->with('success', 'User has been activated.');
        } else {
            return back()->with('success', 'User has been deactivated.');
        }
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['confirmed', 'min:8', 'required']
        ]);

        $user->password = $request->password;
        $user->save();

        return back();
    }
}
