<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthDate extends Model
{
    protected $table = 'month_date';

    protected $fillable = [
        'year',
        'month',
        'maxDate',
    ];
}
