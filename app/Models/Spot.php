<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    protected $fillable = [
        'parking_id'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
