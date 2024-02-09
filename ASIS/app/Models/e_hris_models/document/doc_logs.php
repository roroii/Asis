<?php

namespace App\Models\e_hris_models\document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_logs extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'admin_logs';

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'type_id', 'activity','user_id','active',
    ];
}
