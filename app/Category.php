<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function pays()
    {
    	return $this->hasMany('App\BillPay');
    }

    public function receives()
    {
    	return $this->hasMany('App\BillReceive');
    }
}
