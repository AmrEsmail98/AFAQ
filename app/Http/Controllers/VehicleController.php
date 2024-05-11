<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Models\FuelEntry;
use App\Models\Vehicle;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    use ApiTrait;

    public function vehicle(Request $request)
    {
        $name = $request->input('name');
        $cost = $request->input('cost');
        $createdAt = $request->input('created_at');
        $type = $request->input('type');

        $costSubquery = FuelEntry::select(
            'vehicle_id',
            DB::raw('MAX(cost) as max_cost'),
            DB::raw('MIN(cost) as min_cost')
        )->groupBy('vehicle_id');

        $query = Vehicle::select('vehicles.*', 'fc.max_cost', 'fc.min_cost')
            ->leftJoinSub($costSubquery, 'fc', function ($join) {
                $join->on('vehicles.id', '=', 'fc.vehicle_id');
            });

        // Filtering by type
        if (!empty($type)) {
            switch ($type) {
                case 'service':
                    $query->whereHas('services');
                    break;
                case 'fuel':
                    $query->whereHas('fuelEntries');
                    break;
                case 'insurance':
                    $query->whereHas('insurancePayments');
                    break;
            }
        }

        // Filter by vehicle name
        if (!empty($name)) {
            $query->where('vehicles.name', 'like', "%{$name}%");
        }

        // Order by cost
        if ($cost === 'max') {
            $query->orderBy('fc.max_cost', 'DESC');
        } elseif ($cost === 'min') {
            $query->orderBy('fc.min_cost', 'ASC');
        }

        // Order by creation date
        if ($createdAt === 'max') {
            $query->orderBy('vehicles.created_at', 'DESC');
        } elseif ($createdAt === 'min') {
            $query->orderBy('vehicles.created_at', 'ASC');
        }

        // Load relationships
        $vehicles = $query->with(['services', 'fuelEntries', 'insurancePayments'])
            ->paginate($this->paginateNum());

        $data['Vehicles'] = VehicleResource::collection($vehicles);
        $data['pagination'] = $this->paginationModel($vehicles);

        return $this->dataReturn($data);
    }
}
