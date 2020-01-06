<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'text', 'image', 'link', 'published_at'
    ];
    
    /**
     * Content belongsTo .
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
  
    /**
     * Content belongsToMany .
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function likes()
    {
    	return $this->belongsToMany('App\User', 'likes', 'content_id', 'user_id');
    }
  
    /**
     * Comment has many .
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = user_id, localKey = id)
        return $this->hasMany(Comment::class);
    }
  
    public function getPublishedAtAttribute($value)
    {
      $data = date('H:i d/m/Y', strtotime($value)); 
      return str_replace(':', 'h', $data);
    }
}
