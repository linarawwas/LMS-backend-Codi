<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Classes::first(); this only gets me the first record
        // i should use this: 
           return Classes::get();
       }
       

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Classes::find($id);
    }

    public function search(string $name)
    {
        return Classes::where('class_name', 'like', '%' . $name . '%')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|unique:classes|max:255',

        ]);
        if (auth()->user()->role == 1) {
            return Classes::create($request->all());
        } else {
            // Users with role 3 or unauthorized users cannot create users
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $class = Classes::find($id);
        if (auth()->user()->role == 1) {
            $class->update($request->all());
            return $class;
        } else {
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role == 1) {
            Classes::destroy($id);
            return response(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }
    }

}