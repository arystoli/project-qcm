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
        'name', 'content', 'status', 'post_id'
    ];

    public function post() {

    	return $this->belongsTo(Post::class);
    }
}
