<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanPurchaseUser extends Model
{
    protected $fillable = [
        'course_id',
        'first_name',
        'last_name',
        'mobile',
        'city',
        'batch_id'

    ];

    public function payments()
    {
        return $this->hasMany(PlanPayment::class, 'purchase_user_id');
    }
}
