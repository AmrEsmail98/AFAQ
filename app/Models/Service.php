<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id','start_date','end_date','invoice_number','total','tax','discount','status','purchase_order_number'];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
