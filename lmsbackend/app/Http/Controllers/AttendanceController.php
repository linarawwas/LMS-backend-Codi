<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassSection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve the attendance records for a class section
        $classSection = ClassSection::find($request->class_section_id);
        $attendanceRecords = $classSection->attendance;

        return $attendanceRecords;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'student_id'=> 'required',
            'teacher_id' => 'required',
            'class_section_id' => 'required',
            'status'=>'required|in:1,2,3',
        ]);

        $classSection = ClassSection::findOrFail($request->class_section_id);
        
        $attendance = new Attendance();
        $attendance->student_id = $request->student_id;
        $attendance->teacher_id = $request->teacher_id;
        $attendance->status = $request->status;
        $attendance->date = Carbon::now();

        $classSection->attendance()->save($attendance);

        $attendance->date = Carbon::now();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the class section for an attendance record
        $attendanceRecord = Attendance::find($id);
        $classSection = $attendanceRecord->classSection;

        return $classSection;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attendance = Attendance::find($id);
        $attendance->update($request->all());
        return $attendance;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Attendance::destroy($id);
    }
  
}
