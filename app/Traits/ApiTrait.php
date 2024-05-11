<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ApiTrait
{

    public function paginateNum()
    {
        return 20;
    }

    public function paginationModel($col)
    {
        $data = [
            'total'         => $col->total() ?? 0,
            'count'         => $col->count() ?? 0,
            'per_page'      => $col->perPage() ?? 0,
            'next_page_url' => $col->nextPageUrl() ?? '',
            'perv_page_url' => $col->previousPageUrl() ?? '',
            'current_page'  => $col->currentPage() ?? 0,
            'total_pages'   => $col->lastPage() ?? 0,
        ];

        return $data;
    }

    public function dataReturn($data, $code = 200, $msg = ''): \Illuminate\Http\JsonResponse
    {

        return response()->json([
            'key' => 'success',
            'code' => $code,
            'data' => $data,
        ]);
    }
}
