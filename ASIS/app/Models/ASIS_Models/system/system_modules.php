<?php

namespace App\Models\ASIS_Models\system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class system_modules extends Model
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
