<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_id', 'text'
    ];
  
    /**
     * User belongsTo .
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
  
    public function getCreatedAtAttribute($value)
    {
      $data = date('H:i d/m/Y', strtotime($value)); 
      return str_replace(':', 'h', $data);
    }
}
