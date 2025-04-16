<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::paginate(2),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //    return view('users.create');
    // }


    // public function store(Request $request)
    // {
    // }


    /**
     * Display the specified resource.
     */
    public function show(User $users)
    {
        // return view('users.show', [
        //     'user' => $users,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, $id)
    {
        // dd($id);
        $user = User::find($id);

       return view('Users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the user by ID
        // dd($id);
        $user = User::find($id);

        // Validate inputs
        // $request->validate([
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        //     'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        //     'password' => 'nullable|string|min:8|confirmed',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);


        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = $user->photo;
        }
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'photo' => $imageName,
        ]);

        return redirect()->route('Users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('Users.index')->with('success', 'User deleted successfully.');
    }
}
