<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponser
{
    private function successResponse($data, $code, $user_data = [])
    {
        return response()->json(['data' => $data, 'user_data' => $user_data], $code);
    }

    protected function errorResponse($message, $code, $user_data = [])
    {
        return response()->json(['error' => $message, 'code' => $code, 'user_data' => $user_data], $code);
    }

    protected function showAll(Collection $collection, $code = 200, $user_data = [], $perPage = null)
    {
        if ($code == null) {$code = 200;}
        if ($collection->isEmpty()) {
            return $this->successResponse($collection, $code, $user_data);
        }
        if ($perPage !== null) {
            $collection = $this->paginate($collection, $perPage);
        }
        return $this->successResponse($collection, $code, $user_data);
    }

    protected function showOne(Model $instance, $code = 200, $user_data = [])
    {
        return $this->successResponse($instance, $code, $user_data);
    }
    protected function showMessage($message, $code = 200, $user_data = [])
    {
        return response()->json(['data' => $message, 'user_data' => $user_data], $code);
    }
    protected function showResource($array, $code = 200)
    {
        return response()->json(['data' => $array, 'code' => $code], $code);
    }
    protected function paginate($collection, $perPage = 15)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        $paginated->appends(request()->all());
        return $paginated;
    }
}
