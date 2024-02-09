<?php

namespace App\Models\Interview;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interview\Areas;

class Criteria extends Model
{
    use HasFactory;
    protected $table = 'int_criteria';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'desc',
        'nature',
    ];

    public function area()
    {
        return $this->hasMany(Areas::class, 'criteria_id', 'id');
    }
}
