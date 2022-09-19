<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMTPSettings extends Model
{
    use HasFactory;

    protected $table = 'smtp_settings';

    protected $fillable = [
        'smtp_name',
        'brand_id',
        'smtp_username',
        'smtp_password',
        'smtp_port',
        'smtp_driver',
        'smtp_host',
        'smtp_encryption',
        'smtp_from_address'
    ];
}
