<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'user_id',
        'slot_id',
        'doctor_id',
        'date',
        'description',
        'status',
    ];
}
