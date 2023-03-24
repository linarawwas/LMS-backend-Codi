<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Sections;
use App\Models\ClassSection;


class JoinController extends Controller
{
    public function getAllData()
    {
        $data = Classes::join('class_sections', 'classes.id', '=', 'class_sections.class_id')
            ->join('sections', 'sections.id', '=', 'class_sections.section_id')
            ->whereNull('class_sections.deleted_at') // add this line
            ->select('class_sections.id as id', 'classes.id as class_id', 'classes.class_name', 'sections.id as section_id', 'sections.section_name')
            ->get();
    
        return response()->json($data);
    }
    // return ClassSection::destroy($id);
    



    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'class_id' => 'required|integer',
            'section_id' => 'required|integer'
        ]);
    
        $class = Classes::find($validatedData['class_id']);
        $section = Sections::find($validatedData['section_id']);
    
        if (!$class || !$section) {
            return response()->json(['error' => 'Class or Section not found.'], 404);
        }
    
        $classSection = ClassSection::create([
            'class_id' => $class->id,
            'section_id' => $section->id
        ]);
    
        return response()->json(['message' => 'ClassSection added successfully.', 'data' => $classSection]);
    }
    
    public function edit(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'class_id' => 'required|integer',
            'section_id' => 'required|integer'
        ]);
    
        $class = Classes::find($validatedData['class_id']);
        $section = Sections::find($validatedData['section_id']);
        $classSection = ClassSection::find($id);
    
        if (!$class || !$section) {
            return response()->json(['error' => 'Class or Section not found.'], 404);
        }
    
        if (!$classSection) {
            return response()->json(['error' => 'ClassSection not found.'], 404);
        }
    
        $classSection->class_id = $class->id;
        $classSection->section_id = $section->id;
        $classSection->save();
    
        return response()->json(['message' => 'ClassSection updated successfully.', 'data' => $classSection]);
    }


    public function destroy(int $id)
    {
        $classSection = ClassSection::find($id);
    
        if (!$classSection) {
            return response()->json(['error' => 'ClassSection not found.'], 404);
        }
    
        // Retrieve the related Class and Section records
        $class = Classes::find($classSection->class_id);
        $section = Sections::find($classSection->section_id);
    ClassSection::destroy($id);
        if (!$class || !$section) {
            return response()->json(['error' => 'Related Class or Section not found.'], 404);
        }
    
        // Delete the ClassSection record
        $classSection->delete();
    
        // If there are no other ClassSection records associated with the Class or Section,
        // delete the corresponding Class or Section record as well
        if (!$class->classSections()->exists()) {
            $class->delete();
        }
        if (!$section->classSections()->exists()) {
            $section->delete();
        }
    
        return response()->json(['message' => 'ClassSection, Class, and Section deleted successfully.']);
    }
    


}
