<?php

namespace App\Models\ASIS_Models\signature;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_tempfiles_model extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'user_tempfiles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'folder',
        'filename',
    ];
}
