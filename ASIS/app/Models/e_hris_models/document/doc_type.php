<?php

namespace App\Models\e_hris_models\document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_type extends Model
{
    use HasFactory;

    protected $connection = 'dsscd85_qrdts';
    protected $table = 'doc_type';
    protected $primaryKey = 'id';

}
