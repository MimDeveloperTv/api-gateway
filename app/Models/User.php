<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Enum\Fields;

class User extends Authable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const PHONE_FIELD = Fields::PHONE;
    public const PASSWORD_FIELD = Fields::PASSWORD;
    public const ACTIVE_FIELD = Fields::ACTIVE;

    protected $connection = 'buloro_pay';
    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function findForPassport(string $username): User
    {
        return $this->where([
            [self::PHONE_FIELD, $username],
            [self::ACTIVE_FIELD,true],
        ])->firstOrFail();
    }
}
