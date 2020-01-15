<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillPay extends Model
{
	protected $fillable = ['date_launch','name','value','status','category_id'];

	protected $casts = ['status' => 'boolean'];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
}
