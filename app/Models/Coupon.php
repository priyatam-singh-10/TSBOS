<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'user_id',
        'discount',
        'expiry',
        'status',
        'course_id',
        'bundle_id',
        'student_id'
    ];

    function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    function bundle()
    {
        return $this->belongsTo(CourseBundle::class, 'bundle_id');
    }

    function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
