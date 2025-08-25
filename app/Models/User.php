<?php
namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
use Notifiable;


protected $fillable = ['name','email','password'];
protected $hidden = ['password','remember_token'];


public function notes(): HasMany { return $this->hasMany(Note::class); }


public function getJWTIdentifier() { return $this->getKey(); }
public function getJWTCustomClaims(): array { return []; }
}