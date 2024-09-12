<?php

namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DeadLineScope implements Scope
{
    protected $date;
    protected $time;

    public function __construct($date = false, $time = false)
    {
        $this->date = $date;
        $this->time = $time;
    }

    public function apply(Builder $builder, Model $model)
    {
        $currentTimestamp = Carbon::now();
        $nowDate = $currentTimestamp->format('Y-m-d');
        $nowTime = $currentTimestamp->format('H:i:s');

        $builder->where(function ($query) use ($nowDate, $nowTime) {
            if ($this->date) {
                $query->where('deadline_date', '>=', $nowDate);
            } elseif ($this->date && $this->time) {
                $query->where(function ($query) use ($nowDate, $nowTime) {
                    $query->where('deadline_date', '>', $nowDate)
                        ->orWhere(function ($query) use ($nowDate, $nowTime) {
                            $query->where('deadline_date', $nowDate)
                                ->where('deadline_time', '>=', $nowTime);
                        });
                });
            }
        });
    }
}
