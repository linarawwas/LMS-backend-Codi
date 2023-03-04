<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //DONE  WITH TESTING GETTING ALL USERS
    public function index(User $user)
    {
        if (auth()->user()->role == 1) {
            // Users with role 1 can retrieve a list of all users
            return User::all();
        } elseif (auth()->user()->role == 2) {
            // Users with role 2 can only retrieve users with role 3
            return User::where('role', 3)->get();
        } else {
            // Users with role 3 or unauthorized users cannot retrieve users
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }
    }

    //DONE WITH TESTING FIND BY {id}
    public function show(User $user, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response(['message' => 'User not found.'], 404);
        }

        if (auth()->user()->role == 1 || (auth()->user()->role == 2 && $user->role == 3)) {
            return response(['user' => $user]);
        } else {
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }
    }

    /**
     * Search for a name
     */
    //DONE WITH TESTING SEARCH
    public function search(string $name)
    {

        $userRole = auth()->user()->role;
        if ($userRole == 1) {
            $users = User::where('username', 'like', '%' . $name . '%')->get();
            return response(['users' => $users]);
        } elseif ($userRole == 2) {
            $users = User::where('username', 'like', '%' . $name . '%')
                ->where('role', 3)
                ->get();
            return response(['users' => $users]);
        } else {
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }

    }

    //DONE WITH TESTING CREATE
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:users|max:255',
            'password' => 'required|min:6',
            'email' => 'required|unique:users|email|max:255',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'role' => 'required|in:1,2,3',
            'image' => 'nullable|image|max:2048',
            'phonenb' => 'nullable|integer',
        ]);

        if (auth()->user()->role == 1) {
            // Users with role 1 can create users with any role
            $user = new User();
            $user->fill($validatedData);
        } elseif (auth()->user()->role == 2 && $validatedData['role'] == 3) {
            // Users with role 2 can only create users with role 3
            $user = new User();
            $user->fill($validatedData);
        } else {
            // Users with role 3 or unauthorized users cannot create users
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $user->image = $imageName;
        }

        $user->save();
        return response(['success' => true, 'user' => $user]);
    }


    //DONE WITH TESTING UPDATE
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (auth()->user()->role == 1 || (auth()->user()->role == 2 && $user->role == 3)) {
            $user->update($request->all());
            return $user;
        } else {
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    //DONE WITH TESTING DELETE: the admin cannot delete role 1 also
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->role == 1 && $user->role != 1) {
            // Users with role 1 can delete all users except other users with role 1
            $user->delete();
            return response(['success' => true, 'message' => 'User deleted successfully.']);
        } else if (auth()->user()->role == 2 && $user->role == 3) {
            // Users with role 2 can delete users with role 3
            $user->delete();
            return response(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            // Users with role 3 or unauthorized users cannot delete any users
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }
    }


}