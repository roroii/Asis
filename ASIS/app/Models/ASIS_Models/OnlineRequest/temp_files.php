<?php

namespace App\Models\ASIS_Models\OnlineRequest;
use  App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\OnlineRequest\office_services;

class temp_files extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'temp_files';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'folder',
        'filename',
        'created_at',
        'updated_at',

    ];
    

}
