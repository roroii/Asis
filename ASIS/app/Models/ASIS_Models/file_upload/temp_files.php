<?php

namespace App\Models\ASIS_Models\file_upload;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temp_files extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'temp_files';
    protected $primaryKey = 'id';

    protected $fillable = [

        'folder' ,
        'filename',
    ];
}
