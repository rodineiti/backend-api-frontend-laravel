<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillReceive extends Model
{
    protected $fillable = ['date_launch','name','value','status','category_id'];

    protected $casts = ['status' => 'boolean'];

    protected $appends = ['type'];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function getTypeAttribute()
    {
    	return "in";
    }
}
