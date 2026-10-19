<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CourseBundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'course_ids',
        'subscription_limit',
        'thumbnail',
        'price',
        'bundle_details',
        'status',
        'banner',
    ];
    protected static function booted()
    {
        static::creating(function ($bundle) {
            $now = Carbon::now('Asia/Kolkata');
            $bundle->created_at = $now;
            $bundle->updated_at = $now;
        });

        static::updating(function ($bundle) {
            $bundle->updated_at = Carbon::now('Asia/Kolkata');
        });
    }
    public function bundlePayments()
    {
        return $this->hasMany(BundlePayment::class, 'bundle_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'bundle_courses', 'bundle_id', 'course_id');
    }
}
