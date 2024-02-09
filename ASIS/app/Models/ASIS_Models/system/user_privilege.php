<?php

namespace App\Models\ASIS_Models\system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_privilege extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'admin_user_privilege';

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_id', 'user_id','read','write','create','delete', 'import','export','print','active'
    ];
    public function getModule()
    {
        return $this->hasOne(system_modules::class, 'id', 'module_id')->where('active', 1);
    }
}
