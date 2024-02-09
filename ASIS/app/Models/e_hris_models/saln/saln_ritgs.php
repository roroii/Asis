<?php

namespace App\Models\saln;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saln_ritgs extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'saln_ritgs';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'saln_id',
            'name_of_relative',
            'relationship',
            'position',
            'name_of_agency',
            'active',
            'created_by',
        ];
}
