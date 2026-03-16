<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'User', allOf: [
    new OA\Schema(properties: [
        new OA\Property(property: 'id', title: 'id', description: 'Primary Key', type: 'integer',
            nullable: false),
        new OA\Property(property: 'name', title: 'name', type: 'string', nullable: true),
        new OA\Property(property: 'email', title: 'email', type: 'string', nullable: false),
        new OA\Property(property: 'email_verified_at', title: 'email_verified_at', type: 'string', nullable: true),
        new OA\Property(property: 'password', title: 'password', type: 'string', nullable: false),
        new OA\Property(property: 'two_factor_secret', title: 'two_factor_secret', type: 'string', nullable: true),
        new OA\Property(property: 'two_factor_recovery_codes', title: 'two_factor_recovery_codes', type: 'string', nullable: true),
        new OA\Property(property: 'two_factor_confirmed_at', title: 'two_factor_confirmed_at', type: 'string', nullable: true),
        new OA\Property(property: 'remember_token', title: 'two_factor_confirmed_at', type: 'string', nullable: true),
        new OA\Property(property: 'current_team_id', title: 'current_team_id', type: 'integer', nullable: true),
        new OA\Property(property: 'profile_photo_path', title: 'profile_photo_path', type: 'string', nullable: true),
        new OA\Property(property: 'created_at', title: 'created_at', type: 'string', format: 'string', writeOnly: true, nullable: true),
        new OA\Property(property: 'updated_at', title: 'updated_at', type: 'string', format: 'string', writeOnly: true, nullable: true),
    ], type: 'object')
])]
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'facebook_id',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected $guarded=[];
}
