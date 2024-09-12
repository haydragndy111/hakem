<?php
namespace App\Traits;

use App\Constants\SurveyConstants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

trait SurveyFilters
{

    public function filterData($data, $value)
    {
        $id = Auth::guard('sanctum')->user()->id;

        if ($value == SurveyConstants::STATUS_COMPLETED) {
            $data->whereHas('users', function ($query) use ($id) {
                return $query->where('user_id', $id);
            })->where('status', SurveyConstants::STATUS_COMPLETED);
        } elseif ($value == SurveyConstants::STATUS_IN_PROGRESS) {
            $data->whereHas('users', function ($query) use ($id) {
                return $query->where('user_id', $id);
            })->where('status', SurveyConstants::STATUS_IN_PROGRESS);
        }

        return $data;
    }

    public function sortData($data, $value)
    {
        if ($value == SurveyConstants::SORT_LATEST) {
            $data->orderBy('created_at', 'desc');
        } elseif ($value == SurveyConstants::SORT_EXPIRATION_DATE) {
            $data->orderBy('deadline_date', 'desc');
        }

        return $data;
    }

}
