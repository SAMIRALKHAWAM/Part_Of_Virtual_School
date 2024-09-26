<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecondarySection extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'subject_section_id',
        'name',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /** @noinspection PhpUnused */
    public function SubjectSection(): BelongsTo
    {
        return $this->belongsTo(SubjectSection::class, 'subject_section_id');
    }

    public function UserSecondarySections(): HasMany
    {
        return $this->hasMany(UserSecondarySection::class, 'secondary_section_id');
    }


    public function Videos(): HasMany
    {
        return $this->hasMany(Video::class, 'secondary_section_id');
    }

    public function Files(): HasMany
    {
        return $this->hasMany(File::class, 'secondary_section_id');
    }
}
