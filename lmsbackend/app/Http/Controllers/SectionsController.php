<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Sections::all();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Sections::find($id);
    }



    public function search(string $name)
    {
        return Sections::where('section_name', 'like', '%' . $name . '%')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_name' => 'required|unique:sections|max:255',

        ]);

        if (auth()->user()->role == 1) {
            return Sections::create($request->all());
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
        $section = Sections::find($id);
        if (auth()->user()->role == 1) {
            $section->update($request->all());
            return $section;
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
            Sections::destroy($id);
            return response(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            return response(['message' => 'You are not authorized to perform this action.'], 403);
        }
    }

}