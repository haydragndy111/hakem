<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Constants\BloodGroupConstants;
use App\Constants\UserConstants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'age',
        'blood_group',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'age' => 'integer',
    ];

    protected function bloodGroup(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => BloodGroupConstants::getBloodGroupsValues()[$value],
        );
    }

    protected function gender(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => UserConstants::getUserGenders()[$value],
        );
    }

}
