<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Artel\Support\Traits\ModelTrait;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, ModelTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $guarded = [
        'reset_password_hash'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'reset_password_hash'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
