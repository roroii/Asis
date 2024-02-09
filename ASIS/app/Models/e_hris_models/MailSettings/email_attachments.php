<?php

namespace App\Models\MailSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class email_attachments extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'email_attachments';
    protected $primaryKey = 'id';
    public $timestamp = true;

    protected $fillable = [
        'id', 'folder', 'filename', 'created_at', 'updated_at','created_by'
    ];
}
