<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Live_class extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'course_id',
        'batch_id',
        'class_topic',
        'provider',
        'class_date_and_time',
        'additional_info',
        'note'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Course relation
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Batch relation
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    // public function user() {
    //     return $this->belongsTo(User::class);
    // }
}
