<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UClass extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function ClassSubjects(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'class_id');
    }

    /** @noinspection PhpUnused */
    public function UserClasses(): HasMany
    {
        return $this->hasMany(UserClass::class, 'class_id');
    }
}
