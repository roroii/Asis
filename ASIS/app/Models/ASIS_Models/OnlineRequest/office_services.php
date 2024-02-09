<?php

namespace App\Models\ASIS_Models\OnlineRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\OnlineRequest\offices;

class office_services extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'office_services';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'office_id',
        'services',
        'added_by',
        'active',
        'created_at',
        'updated_at',

    ];


    public function get_office_services()
    {
        return $this->HasOne(offices::class, 'id', 'office_id');
    }


}
