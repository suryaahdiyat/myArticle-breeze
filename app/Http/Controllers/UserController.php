<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('here');
        return view("user.index", [
            "users"=> User::latest()->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("user.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        // dd($request['role']);

        $initial = $this->getInitials($request->name);

        $user = User::create([
            'name' => $request->name,
            'initial' => $initial,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request['role']);
        return redirect()->route('users.index')->with('success', 'added new user successfully!');
    }

    protected function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper($word[0]);
        }

        return $initials;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', ['user'=> $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,'.$user->id,
            // 'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        // dd($request['role']);

        //jalan ketika change pass active
        if($request->cPass == 'on'){
            // dd('pass active');
            $validatedPassword = $request->validate([
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
            $validatedData['password'] = $validatedPassword['password'];
        }
        // dd('does not active');
        $validatedData['initial'] = $this->getInitials($request->name);
        // dd($validatedData);

        $user->update($validatedData);

        $user->syncRoles([$request['role']]);
        return redirect()->route('users.index')->with('success', 'updated user successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'user deleted successfully!');
    }
}
