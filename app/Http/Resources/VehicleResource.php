<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        $fuelEntryDates = $this->fuelEntryDates->pluck('created_at')->map(function ($date) {
            return $date ? $date->format('Y-m-d') : null;
        });

        // Collect and format insurance payment dates
        $insurancePaymentDates = $this->insurancePaymentDates->pluck('created_at')->map(function ($date) {
            return $date ? $date->format('Y-m-d') : null;
        });

        // Collect and format service dates
        $serviceDates = $this->serviceDates->pluck('created_at')->map(function ($date) {
            return $date ? $date->format('Y-m-d') : null;
        });

        return [

            'id' => $this->id,
            'name' => $this->name,
            'plate_number' => $this->plate_number,
            'type' => $this->getExpenseType(),
            'cost' => [
                'fuel_cost' => $this->totalFuelCost->first() ? (int) $this->totalFuelCost->first()->total_cost : 0,
                'insurance_amount' => $this->totalInsuranceAmount->first() ? $this->totalInsuranceAmount->first()->total_amount : 0,
                'total_serives' => $this->totalServices->first() ? $this->totalServices->first()->total : 0
            ],

            'created_at' => [
                'entry_date' => $fuelEntryDates,
                'contarct_date' => $insurancePaymentDates,
                'created_at' => $serviceDates,

            ],

        ];
    }

    protected function getExpenseType()
    {
        $types = [];
        if ($this->services()->exists()) {
            $types[] = 'service';
        }
        if ($this->fuelEntries()->exists()) {
            $types[] = 'fuel';
        }
        if ($this->insurancePayments()->exists()) {
            $types[] = 'insurance';
        }

        return $types;
    }
}
