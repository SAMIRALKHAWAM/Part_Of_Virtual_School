<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSecondarySection extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'actor_id',
        'secondary_section_id',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function Actor(): BelongsTo
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }

    public function SecondarySection(): BelongsTo
    {
        return $this->belongsTo(SecondarySection::class, 'secondary_section_id');
    }
}
