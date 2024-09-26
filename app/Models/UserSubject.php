<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubject extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'actor_id',
        'subject_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function Actor(): BelongsTo
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }

    public function Subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function UserSubjects(): HasMany
    {
        return $this->hasMany(SubjectSection::class, 'user_subject_id');
    }
}
