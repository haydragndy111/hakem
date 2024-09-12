<?php
namespace App\Traits;

use App\Constants\CubeConstants;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait CubeFilters
{
    // public $id;

    // public function __construct()
    // {
    //     $this->id = Auth::guard('sanctum')->user()->id;
    // }

    public function filterCollection(Request $request, $cubeCollection)
    {
        $request->validate([
            'sort' => 'numeric|nullable',
            'filter' => 'numeric|nullable',
        ]);

        $sort = $request->sort ?? null;
        $filter = $request->filter ?? null;

        if ($filter) {
            $cubeCollection = $this->filterGeneral($cubeCollection, $filter);
        }

        if ($sort) {
            $cubeCollection = $this->sortData($cubeCollection, $sort);
        }

        return $cubeCollection;
    }

    public function filterGeneral($data, $value)
    {
        $id = Auth::guard('sanctum')->user()->id;

        if ($value == CubeConstants::FILTER_COMPLETED) {
            $data->whereHas('cubeUsers', function ($query) use ($id) {
                return $query->where('user_id', $id);
            })->where('status', CubeConstants::STATUS_SUCCESS);
        } elseif ($value == CubeConstants::FILTER_IN_PROGRESS) {
            $data->whereHas('cubeUsers', function ($query) use ($id) {
                return $query->where('user_id', $id)
                    ->where('finished_at', null);
            });
        } elseif ($value == CubeConstants::FILTER_UNAVAILABLE) {
            $data->where('available_from', '>', Carbon::now()->format('Y-m-d'));
        }

        return $data;
    }

    public function sortData($data, $value)
    {
        if ($value == CubeConstants::SORT_LATEST) {
            $data->latest();
        } elseif ($value == CubeConstants::SORT_ACHIEVEMENTS) {
            $data->withCount('achievements')
                ->orderBy('achievements_count');
        } elseif ($value == CubeConstants::SORT_EXPIRATION_DATE) {
            $data->orderBy('deadline_date', 'desc');
        } elseif ($value == CubeConstants::SORT_ALPHABETICAL) {
            $data->orderBy('name', 'asc');
        } elseif ($value == CubeConstants::SORT_ALPHABETICAL_REVERSE) {
            $data->orderBy('name', 'desc');
        }

        return $data;
    }

}
