<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSubject extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'class_id',
        'subject_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function UClass(): BelongsTo
    {
        return $this->belongsTo(UClass::class, 'class_id');
    }

    public function Subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function Exams(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'class_subject_id');
    }

}
