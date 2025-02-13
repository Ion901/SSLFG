<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['post_title','post_content'];
    public $timestamps = false;
    public function image(){
        return $this->hasMany(PostImages::class,'id_post');
    }

    public function competition(){
        return $this->belongsTo(Competitions::class,'id_competition');
    }
}
