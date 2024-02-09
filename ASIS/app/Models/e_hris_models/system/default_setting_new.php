<?php

namespace App\Models\e_hris_models\system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class default_setting_new extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'default_setting';
    protected $primaryKey = 'id';

    protected $fillable = [
        'key',
        'value',
        'description',
        'link',
        'image',
        'active',
        'created_by'
    ];
}
