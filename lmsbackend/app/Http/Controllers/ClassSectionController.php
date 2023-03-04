<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ClassSection::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'class_id' => 'required',
            'section_id' => 'required',
        ]);
        return ClassSection::create($request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ClassSection::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $class_section = ClassSection::find($id);
        $class_section->update($request->all());
        return $class_section;
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        return ClassSection::destroy($id);
    }

}