<?php

namespace App\Models\ASIS_Models\enroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmp_logoFile extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'logo_tmp_file';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'folder', 'filename',
    ];
}
