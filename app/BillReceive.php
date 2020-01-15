<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillReceive extends Model
{
    protected $fillable = ['date_launch','name','value','status'];

    protected $casts = ['status' => 'boolean'];
}
