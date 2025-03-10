<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spot_id',
        'start_date',
        'end_date',
    ];

    public function spot()
    {
        return $this->belongsTo(Spot::class);
    } 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
