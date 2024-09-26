<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Actor extends Authenticatable
{
    use HasFactory, HasApiTokens, HasRoles, HasPermissions;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'type',
    ];


    protected $hidden = [
        'password',
        'type',
        'created_at',
        'updated_at',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function UserSubjects(): HasMany
    {
        return $this->hasMany(UserSubject::class, 'actor_id');
    }

    public function UserSecondarySections(): HasMany
    {
        return $this->hasMany(UserSecondarySection::class, 'actor_id');
    }

    /** @noinspection PhpUnused */
    public function UserClasses(): HasMany
    {
        return $this->hasMany(UserClass::class, 'actor_id');
    }
}
