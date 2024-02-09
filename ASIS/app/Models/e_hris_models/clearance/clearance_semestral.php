<?php

namespace App\Models\clearance;

use App\Models\doc_type;
use App\Models\tbl_responsibilitycenter;
use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_semestral extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'clearance_semestral';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'clearance_id', 'documents', 'signatory', 'office', 'active', 'created_by',
    ];

    public function get_User_Details()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'signatory')->where('active', 1);
    }

}
