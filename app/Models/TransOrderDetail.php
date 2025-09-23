<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransOrderDetail extends Model
{
    protected $fillable = [
        'id_order',
        'id_service',
        'qty',
        'subtotal',
        'notes',
    ];
    protected $casts = [
        'qty' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function transOrder()
    {
        return $this->belongsTo(TransOrder::class, 'id_order');
    }

    public function typeOfService()
    {
        return $this->belongsTo(TypeOfService::class, 'id_service');
    }
}
