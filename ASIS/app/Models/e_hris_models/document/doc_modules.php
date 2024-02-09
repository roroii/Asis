<?php

namespace App\Models\e_hris_models\document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_modules extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'admin_modules';

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_name', 'link','important','read','write','create','delete', 'import','export','print','active'
    ];
}
