<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMTP extends Model
{
    use HasFactory;
    protected $table = 'smtps';
    protected $fillable = [
    'mailer',
    'host',
    'port',
    'username',
    'password',
    'encryption',
    'sender',
];
}
