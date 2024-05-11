<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelEntry extends Model
{
    use HasFactory;

    protected $fillable = ['cost','volume','entry_date','vehicle_id'];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
