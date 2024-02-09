<?php

namespace App\Models\e_hris_models\document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_user_privilege extends Model
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
        return $this->hasOne(doc_modules::class, 'id', 'module_id')->where('active', 1);
    }
}
