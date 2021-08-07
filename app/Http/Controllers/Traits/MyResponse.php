<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

trait MyResponse {

    private function generate_response($data, $status = true, $message = 'Success')
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function collection_response(Request $request, Collection $collection)
    {
        return $request->wantsJson() ? $this->generate_response($collection) : $collection;
    }

    public function pagination_response(Request $request, Paginator $paginator)
    {
        return $request->wantsJson() ? $this->generate_response($paginator) : $paginator;
    }

    public function response(Request $request, $data, $status = true, $message = 'Success')
    {
        return $request->wantsJson() ? $this->api_response($data, $status, $message) : $data;
    }

    public function api_response($data, $status = true, $message = 'Success')
    {
        return $this->generate_response($data, $status, $message);
    }

}