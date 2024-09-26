<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'exam_section_id',
        'question_type_id',
        'question',
        'file',
        'mark',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function ExamSection(): BelongsTo
    {
        return $this->belongsTo(ExamSection::class, 'exam_section_id');
    }

    public function Answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
