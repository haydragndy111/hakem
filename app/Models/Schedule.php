<?php

namespace App\Models;

use App\Enums\DaysOfTheWeek;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $casts = [
        'day_of_week' => DaysOfTheWeek::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

}
