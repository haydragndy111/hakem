<?php

namespace App\Models;

use App\Constants\BloodGroupConstants;
use App\Constants\DoctorConstants;
use App\Models\Scopes\DoctorActiveScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialization_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'age',
        'experience',
        'blood_group',
        'password',
        'is_featured',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new DoctorActiveScope);
    }

    public function createToken(array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => 'web',
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'expires_at' => Carbon::now()->addDays(7),
        ]);
        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    // Relations
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'schedule_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Accessors
    protected function bloodGroup(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => BloodGroupConstants::getBloodGroupsValues()[$value],
        );
    }

    protected function gender(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => DoctorConstants::getUserGenders()[$value],
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => DoctorConstants::getDoctorStatus()[$value],
        );
    }

    // scopes
    public function scopeIsFeatured($query)
    {
        return $query->where('is_featured', DoctorConstants::FEATURED);
    }

}
