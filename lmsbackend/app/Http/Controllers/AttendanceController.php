<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;



class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Attendance::all();
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
        ])
        ;
        $data = $request->all();
        $data['date'] = Carbon::now();
        return Attendance::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Attendance::find($id);
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
