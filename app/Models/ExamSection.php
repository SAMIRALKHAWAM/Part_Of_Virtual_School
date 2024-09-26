<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSection extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'exam_id',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function Exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    /** @noinspection PhpUnused */
    public function ExamSectionMedia(): HasMany
    {
        return $this->hasMany(ExamSectionMedia::class, 'exam_section_id');
    }

    /** @noinspection PhpUnused */
    public function Questions(): HasMany
    {
        return $this->hasMany(Question::class, 'exam_section_id');
    }
}
