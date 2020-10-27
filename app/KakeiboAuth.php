<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KakeiboAuth extends Model
{
    protected $table = 'kakeibo_auth';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}
