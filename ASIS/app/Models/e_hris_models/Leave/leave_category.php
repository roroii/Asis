<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class leave_category extends Model
{
    use HasFactory;
    protected $conncection= 'e-hris';
    protected $table= 'leave_category';
    protected $primaryKey='id';

    protected $fillable= [
        'id',
        'name',
        'created_at',
        'updated_at',

    ];


  
}
