<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSectionMedia extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'exam_section_id',
        'url',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function ExamSection(): BelongsTo
    {
        return $this->belongsTo(ExamSection::class, 'exam_section_id');
    }
}
