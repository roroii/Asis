<?php

namespace App\Models\global_;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class global_signatories extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'global_signatories';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'id', 'name', 'type', 'type_id', 'employee_id','suffix_name','for', 'description', 'created_by', 'active', 'approved', 'allow_esig', 'action', 'action_taken_status', 'created_at', 'updated_at'
        ];


        public function getUserinfo()
        {
            return $this->hasOne(tblemployee::class, 'agencyid', 'employee_id')->where('active', 1);
        }

        public function getSignatoryHistory()
        {
            return $this->hasMany(global_signatories_history::class, 'signatory_id', 'id')->where('active', 1);
        }

}
