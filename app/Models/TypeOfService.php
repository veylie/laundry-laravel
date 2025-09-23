<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeOfService extends Model
{
    protected $fillable = [
        'service_name',
        'price',
        'description'
    ];
}
