<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.s
     *
     * @var array<int, string>
     */

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    const ROLE_ADMIN = 1;
    const ROLE_TEACHER = 2;
    const ROLE_STUDENT = 3;

    protected $fillable = [
        'username',
        'password',
        'email',
        'firstname',
        'lastname',
        'role',
        'image',
        'phonenb',
      

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function classSection()
    {
        return $this->belongsToMany(ClassSection::class, 'user_class_sections','user_id','class_section_id');
    }


}