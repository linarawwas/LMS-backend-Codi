<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ClassSection extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'class_id',
        'section_id',

    ];


    public function ClassId()
    {
        return $this->belongsTo(Classes::class);
    }

    public function SectionId()
    {
        return $this->belongsTo(Sections::class);
    }

    public function UserClassSection()
    {
        return $this->hasMany(User::class, 'user_class_sections');
    }


    public function Attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}