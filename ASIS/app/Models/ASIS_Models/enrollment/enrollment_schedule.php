<?php

namespace App\Models\ASIS_Models\enrollment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enrollment_schedule extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'enrollment_schedule';
    protected $primaryKey = 'id';

    protected $fillable = [

        'title',
        'description',
        'slot_type',
        'slots',
        'date',
        'sem',
        'status',
        'active',
    ];

    public function isAdmin()
    {
        return $this->hasOne(enrollment_list::class, 'studid', 'studid')->where('role', 'Admin');
    }

}
