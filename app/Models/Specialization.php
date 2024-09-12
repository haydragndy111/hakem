<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
