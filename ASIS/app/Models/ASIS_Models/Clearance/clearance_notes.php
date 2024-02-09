<?php

namespace App\Models\ASIS_Models\Clearance;

use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\ASIS_Models\system\status_codes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clearance_notes extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'clearance_notes';
    protected $primaryKey = 'id';

    protected $fillable = [

        'created_by',
        'type',
        'title',
        'program',
        'note',
        'dismiss',
        'active',

    ];

    public function get_Signatories()
    {
        return $this->hasOne(clearance_signatories::class, 'signatory_id', 'created_by')->where('active', 1);
    }

    public function get_EmployeeSignatoryData()
    {
        return $this->hasOne(employee::class, 'agencyid', 'created_by');
    }
}
