<?php

namespace App\Models\ASIS_Models\SemSched;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_schYr extends Model
{
    use HasFactory;

    protected $connection = '';
    protected $table = '';
    protected $primaryKey = '';

    public $timestamp = true;

    protected $fillable = [
        'id', 'year', 'active'
    ];
}
