<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurancePayment extends Model
{
    use HasFactory;
    protected $fillable = ['amount','expiration_date','contract_date','vehicle_id'];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
