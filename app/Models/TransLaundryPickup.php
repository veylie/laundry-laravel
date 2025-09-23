<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransLaundryPickup extends Model
{
    protected $fillable = [
        'id_order',
        'id_customer',
        'pickup_date',
        'notes'
    ];

    protected $casts = [
        'pickup_date' => 'date'
    ];

    public function transOrder()
    {
        return $this->belongsTo(TransOrder::class, 'id_order');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
}
