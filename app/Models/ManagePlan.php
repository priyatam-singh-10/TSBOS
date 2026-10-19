<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagePlan extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
