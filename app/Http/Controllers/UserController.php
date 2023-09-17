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
        // $users = User::with('roles')->pluck('name')->get();

        return inertia('User/Index', [
            'users' => User::with('roles')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('fname', 'like', "%{$search}%")
                        ->orWhere('lname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->paginate(5)
                ->withQueryString(),
            'filters' => $request->only(['search']),
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
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'user' => ['required', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required'],
        ]);

        $role = $fields['role'];
        unset($fields['role']);

        $user = User::create($fields);

        $user->assignRole($role);

        return redirect('/users');
        // dd($fields, $role);
    }

    public function edit(User $user)
    {
        $userWithRoles = User::with(['roles' => function ($query) {
            $query->select('name');
        }])->find($user->id);

        // dd($userWithRoles);
        return inertia('User/Edit', [
            'user' => $userWithRoles,
            'roles' => Role::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $fields = $request->validate([
            'fname' => ['string', 'max:255'],
            'lname' => ['string', 'max:255'],
            'user' => ['string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->update($fields);

        return back();
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back();
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

        return redirect('/users');
    }
}
