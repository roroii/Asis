<?php

namespace App\Models\ASIS_Models\studentFees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\studentFees\collection_header;
use App\Models\ASIS_Models\studentFees\fees;

class collection_details extends Model
{
    use HasFactory;

    protected $connection = "spamast_digos_srgb";
    protected $table = "collection_details";
    protected $primaryKey = "oid";

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = ['oid','orno','feecode','amt'];

    /*get the collectiondetails*/
    public function getCollectionDetails()
    {
        return $this->hasOne(collection_header::class,'orno','orno');
    }

    /*get the feecode description*/
    public function getFeeCodeDesc()
    {
        return $this->hasOne(fees::class,'feecode','feecode');
    }
}
