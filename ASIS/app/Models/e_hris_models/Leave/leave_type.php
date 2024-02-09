<?php

namespace App\Models\Leave;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave_type extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'leave_type';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'id',
            'typename',
            'category',
            'qualifygender',
            'qualify_cs',
            'numberofleaves',
            'active',
            'username',
            'leave_cat',
            'ledger_col_order',
            'value_source',
            'long_name',
            'created_at',
            'updated_at',
        ];

}
