<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;
    const STATUS_PRESENT = 1;
    const STATUS_ABSENT = 2;
    const STATUS_LATE = 3;
    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $fillable = [
        'student_id',
        'teacher_id',
        'class_section_id',
        'date',
        'status',

    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // public function teacher()
    // {
    //     return $this->belongsTo(User::class, 'teacher_id');
    // } 
    // update by lina: [we do no have a teacher attendance]

    public function classSection()
    {
        // return $this->hasMany(ClassSection::class);
    // update by lina: [single attandence records can only belong to one classsection]
    return $this->belongsTo(ClassSection::class);

}

}