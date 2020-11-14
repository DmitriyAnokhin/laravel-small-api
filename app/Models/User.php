<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use UserMethods;

    const TYPE_PRIVATE_PERSON = 'PRIVATE_PERSON';
    const TYPE_LEGAL_ENTITY = 'LEGAL_ENTITY';

    const TYPES = [
        self::TYPE_PRIVATE_PERSON,
        self::TYPE_LEGAL_ENTITY,
    ];

    protected $fillable = [
        'email',
        'password',
        'name',
        'phone',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Demand::class, 'executor_id', 'demand_id', 'id');
    }

}
