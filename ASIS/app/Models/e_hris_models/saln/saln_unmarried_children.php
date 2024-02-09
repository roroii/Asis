<?php

namespace App\Models\saln;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saln_unmarried_children extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'saln_unmarried_children';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'saln_id',
            'name',
            'dateofbirth',
            'age',
            'active',
            'created_by',
        ];
}
