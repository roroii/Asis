<?php

namespace App\Models\employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_address extends Model
{
    use HasFactory;
    protected $connection = 'dsscd85_kyoshi';
    protected $table = 'employee_address';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
