<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'plate_number', 'license', 'year', 'vin', 'imei'];
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function fuelEntries()
    {
        return $this->hasMany(FuelEntry::class);
    }

    public function insurancePayments()
    {
        return $this->hasMany(InsurancePayment::class);
    }

    public function totalFuelCost() {
        return $this->hasMany(FuelEntry::class)->selectRaw('vehicle_id, SUM(cost) as total_cost')
            ->groupBy('vehicle_id');
    }
    
    public function totalInsuranceAmount() {
        return $this->hasMany(InsurancePayment::class)->selectRaw('vehicle_id, SUM(amount) as total_amount')
            ->groupBy('vehicle_id');
    }

    public function totalServices() {
        return $this->hasMany(Service::class)->selectRaw('vehicle_id, SUM(total) as total')
            ->groupBy('vehicle_id');
    }
    
    public function fuelEntryDates() {
        return $this->hasMany(FuelEntry::class)->select('vehicle_id', 'created_at');
    }

    // Method to get all entry dates for insurance payments
    public function insurancePaymentDates() {
        return $this->hasMany(InsurancePayment::class)->select('vehicle_id', 'created_at');
    }

    // Method to get all entry dates for services
    public function serviceDates() {
        return $this->hasMany(Service::class)->select('vehicle_id', 'created_at');
    }
}
