<?php

namespace App\Models\travel_order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class to_members extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'to_members';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'to_id', 'user_id', 'active', 'created_by', 'created_at', 'updated_at'
        ];
}
