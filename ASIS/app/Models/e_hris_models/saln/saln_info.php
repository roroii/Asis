<?php

namespace App\Models\saln;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saln_info extends Model
{
    use HasFactory;


    protected $connection = 'e-hris';
    protected $table = 'saln_info';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'as_of',
            'joint_filing',
            'separate_filing',
            'not_applicable',
            'declarant_firstname',
            'declarant_lastname',
            'declarant_middlename',
            'declarant_address',
            'declarant_position',
            'declarant_agency_office',
            'declarant_office_address',
            'declarant_id',
            'declarant_id_num',
            'declarant_id_date',
            'spouse_firstname',
            'spouse_lastname',
            'spouse_middlename',
            'spouse_position',
            'spouse_agency_office',
            'spouse_office_address',
            'spouse_id',
            'spouse_id_num',
            'spouse_id_date',
            'acquisition_assets_total',
            'acquisition_personal_prop_sub_total',
            'acquisition_personal_prop_total',
            'liabilities_total',
            'net_worth',
            'biafc_has_business_interest',
            'ritgs_has_gov_serv_relative',
            'active',
            'created_by',
        ];

        public function get_biafc()
        {
            return $this->hasMany(saln_biafc::class, 'saln_id', 'id')->where('active', 1);
        }

        public function get_liabilities()
        {
            return $this->hasMany(saln_liabilities::class, 'saln_id', 'id')->where('active', 1);
        }

        public function get_personal_prop()
        {
            return $this->hasMany(saln_personal_properties::class, 'saln_id', 'id')->where('active', 1);
        }

        public function get_real_prop()
        {
            return $this->hasMany(saln_real_properties::class, 'saln_id', 'id')->where('active', 1);
        }

        public function get_ritgs()
        {
            return $this->hasMany(saln_ritgs::class, 'saln_id', 'id')->where('active', 1);
        }

        public function get_unm_chil()
        {
            return $this->hasMany(saln_unmarried_children::class, 'saln_id', 'id')->where('active', 1);
        }
}
