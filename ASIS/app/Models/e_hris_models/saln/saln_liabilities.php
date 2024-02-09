<?php

namespace App\Models\saln;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saln_liabilities extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'saln_liabilities';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'saln_id',
            'nature',
            'name_of_creditors',
            'out_standing_balance',
            'active',
            'created_by',
        ];
}
