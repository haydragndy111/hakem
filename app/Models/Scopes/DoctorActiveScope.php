<?php

namespace App\Models\Scopes;

use App\Constants\DoctorConstants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DoctorActiveScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getTable() . ".status", DoctorConstants::STATUS_ACTIVE);
    }
}
