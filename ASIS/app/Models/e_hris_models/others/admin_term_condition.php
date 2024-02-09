<?php

namespace App\Models\others;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin_term_condition extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'admin_term_condition';
    protected $primaryKey = 'id';

    protected $fillable =
        [
             'title', 'desc_content', 'author', 'active', 'created_at', 'updated_at', 'created_by'
        ];
}
