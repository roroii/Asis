<?php

namespace App\Models\EmployeeRating;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_spms extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'tbl_spms';
    protected $primaryKey = 'id';

    public $timestamp = true;

    protected $fillable = [
        'id','ref_id', 'rating', 'adjectival', 'desc', 'active', 'created_at', 'updated_at'
    ];
}
