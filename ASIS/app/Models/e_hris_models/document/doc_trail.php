<?php

namespace App\Models\e_hris_models\document;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_trail extends Model
{
    use HasFactory;
    protected $connection = 'dsscd85_qrdts';
    protected $table = 'doc_trail';
    protected $primaryKey = 'id';

    protected $fillable = [
        'track_number',
        'trail_id',
        'type',
        'type_id',
        'target_user_id',
        'active',
        'action',
        'created_by',
        'receive_date',
        'release_date',
    ];



public function get_user()
{
    return $this->hasOne(tblemployee::class, 'agencyid', 'target_user_id')->where('active', 1);
}

public function get_sub_trail()
{
    return $this->hasMany(self::class, 'created_by', 'target_user_id')->where('active', 1)->with('get_sub_trail');
}

public function get_sub_sub_trail()
{
    return $this->get_sub_trail()->with('get_sub_sub_trail');
}

public static function tree(){

    $all_trails = doc_trail::get();

    $root_trails = $all_trails->whereNull('trail_id');

    self::formatTree($root_trails,$all_trails);

    return $root_trails;
}

private static function formatTree($trails,$all_trails){

    foreach ($trails as $trail) {
        $trail->sub_trail = $all_trails->where('trail_id',$trail->id)->values();

        if($trail->sub_trail->isNotEmpty()){
            self::formatTree($trail->sub_trail,$all_trails);
        }
    }
}

}
