<?php

namespace App\Models\global_;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class global_signatories_history extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'global_signatories_history';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'id', 'signatory_id', 'action', 'note', 'employee_id', 'created_by','active', 'created_at', 'updated_at'
        ];


        public function getUserinfo()
        {
            return $this->hasOne(tblemployee::class, 'agencyid', 'employee_id')->where('active', 1);
        }
}
