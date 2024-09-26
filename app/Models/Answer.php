<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'question_id',
        'answer',
        'file',
        'mark',
    ];

    public function Question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
