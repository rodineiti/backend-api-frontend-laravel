<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillPay extends Model
{
	protected $fillable = ['date_launch','name','value','category_id'];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
}
