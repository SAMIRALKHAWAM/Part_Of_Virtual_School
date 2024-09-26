<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'secondary_section_id',
        'url',
        'size_of_file',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function SecondarySection():BelongsTo{
        return $this->belongsTo(SecondarySection::class,'secondary_section_id');
    }
}
