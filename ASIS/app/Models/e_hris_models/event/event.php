<?php

namespace App\Models\event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'payroll_holidays';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'title',
            'date',
            'start',
            'end',
            'created_by',
            'active',
        ];
}
