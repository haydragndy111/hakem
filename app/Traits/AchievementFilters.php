<?php
namespace App\Traits;

use App\Constants\AchievementConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait AchievementFilters
{

    public function filterData($data, $value)
    {
        $id = Auth::guard('sanctum')->user()->id;

        if ($value == AchievementConstants::FILTER_COMPLETED) {
            $data->whereHas('achievementUsers', function ($query) use ($id) {
                return $query->where('user_id', $id);
            })->where('status', AchievementConstants::s);
        } elseif ($value == AchievementConstants::FILTER_IN_PROGRESS) {
            $data->whereHas('achievementUsers', function ($query) use ($id) {
                return $query->where('user_id', $id)
                    ->where('finished_at', null);
            });
        } elseif ($value == AchievementConstants::FILTER_UNAVAILABLE) {
            $data->where('available_from', '>', Carbon::now()->format('Y-m-d'));
        }

        return $data;
    }

    public function sortData($data, $value)
    {
        if ($value == AchievementConstants::SORT_LATEST) {
            $data->latest();
        } elseif ($value == AchievementConstants::SORT_CUBES) {
            $data->with(['cube' => function ($query) {
                $query->orderBy('created_at');
            }]);
            // $data->with('cube');
        } elseif ($value == AchievementConstants::SORT_EXPIRATION_DATE) {
            $data->orderBy('deadline_date', 'desc');
        } elseif ($value == AchievementConstants::SORT_ALPHABETICAL) {
            $data->orderBy('title', 'asc');
        } elseif ($value == AchievementConstants::SORT_ALPHABETICAL_REVERSE) {
            $data->orderBy('title', 'desc');
        }

        return $data;
    }
}
