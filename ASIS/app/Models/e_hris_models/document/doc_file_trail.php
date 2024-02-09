<?php

namespace App\Models\e_hris_models\document;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_file_trail extends Model
{
    use HasFactory;
    protected $connection = 'dsscd85_qrdts';
    protected $table = 'doc_file_trail';
    protected $primaryKey = 'id';

    protected $fillable = [
        'doc_file_id',
        'track_number',
        'user_id',
        'doc_file_trail_id',
        'active',
        'to',
        'from',
        'expected_release_date',
        'release_date',
        'expected_receive_date',
        'receive_date',
        'currently_file_holder',
        'end_trail',
        'action',
    ];


public function get_sub_trail()
{
    return $this->hasMany(self::class,'doc_file_trail_id', 'id');
    // finds other records where their 'parent_id' is the parent's 'id'
}

public function get_user()
{
    return $this->hasOne(tblemployee::class, 'agencyid', 'user_id')->where('active', 1);
}

}
