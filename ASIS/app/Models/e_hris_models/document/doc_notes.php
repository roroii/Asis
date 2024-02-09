<?php

namespace App\Models\e_hris_models\document;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_notes extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'admin_notes';

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'desc', 'active','dismiss','created_by', 'type_id', 'type',
    ];

    public function getAuthor()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'created_by')->where('active', 1);
    }
}
