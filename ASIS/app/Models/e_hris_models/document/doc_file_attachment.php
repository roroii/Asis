<?php

namespace App\Models\e_hris_models\document;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_file_attachment extends Model
{
    use HasFactory;

    protected $connection = 'dsscd85_qrdts';
    protected $table = 'doc_file_attachment';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'doc_file_id',
            'name',
            'desc',
            'view_count',
            'path',
            'url',
            'type',
            'email_cc',
            'created_by',
            'active',
            'added_attachments',
        ];

    public function getUsers()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'created_by')->where('active', 1);
    }
}

