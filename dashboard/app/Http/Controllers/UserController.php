<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(5)
            ->withQueryString()
            ->through(fn ($user) => new UserResources($user));

        return Inertia::render('User/Index', ['users' => $users]);
    }

    public function show(User $user)
    {
        return Inertia::render('User/Show', ['user' => $user]);
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'email_subscribe' => 'boolean|nullable',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_subscribe' => $request->email_subscribe,
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'nullable',
            'email' => 'nullable|email',
            'password' => 'nullable|min:6',
            'email_subscribe' => 'nullable',
        ]);

        $user->update($request->all());

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
