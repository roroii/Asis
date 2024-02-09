<?php

namespace App\Models\ASIS_Models\studentFees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class collection_header extends Model
{
    use HasFactory;

    protected $connection = "spamast_digos_srgb";
    protected $table = "collection_header";
    protected $primaryKey = "oid";

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = ['oid','orno','sy','sem','studid','payee','paydate'];
}
