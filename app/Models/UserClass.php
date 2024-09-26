<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserClass extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'actor_id',
        'class_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function Actor(): BelongsTo
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }

    public function Class(): BelongsTo
    {
        return $this->belongsTo(UClass::class, 'class_id');
    }

    public function SubjectSections(): HasMany
    {
        return $this->hasMany(SubjectSection::class, 'user_class_id');
    }
}
