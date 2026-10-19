<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanPayment extends Model
{
    protected $fillable = [
        'purchase_user_id',
        'payment_id',
        'order_id',
        'amount',
        'status'
    ];

    public function purchaseUser()
    {
        return $this->belongsTo(PlanPurchaseUser::class, 'purchase_user_id');
    }
}
