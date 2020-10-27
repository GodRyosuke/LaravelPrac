<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kakeibo extends Model
{
    protected $table = 'kakeibo';
    
    protected $fillable = [
        'year',
        'month',
        'day',
        'diff',
        'what',
        'savings',
        'memo',
        'author_id'
    ];
}
