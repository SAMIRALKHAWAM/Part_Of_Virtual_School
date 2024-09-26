<?php

namespace App\Models;

use Hamcrest\AssertionError;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrimarySection extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function SubjectSections(): HasMany
    {
        return $this->hasMany(SubjectSection::class, 'primary_section_id');
    }

}
