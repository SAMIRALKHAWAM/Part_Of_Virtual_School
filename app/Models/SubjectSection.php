<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubjectSection extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_subject_id',
        'user_class_id',
        'primary_section_id',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeOrder($request)
    {
        return $request->orderBy('created_at', 'desc');
    }

    public function UserSubject(): BelongsTo
    {
        return $this->belongsTo(UserSubject::class, 'user_subject_id');
    }

    public function UserClass(): BelongsTo
    {
        return $this->belongsTo(UserClass::class, 'user_class_id');
    }

    public function PrimarySection(): BelongsTo
    {
        return $this->belongsTo(PrimarySection::class, 'primary_section_id');
    }

    public function SecondarySections(): HasMany
    {
        return $this->hasMany(SecondarySection::class, 'subject_section_id');
    }
}
