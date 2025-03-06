<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['post_title','post_content','post_date'=>'datetime','id_category','id_competition'];
    public $timestamps = false;
    public function image(){
        return $this->hasMany(PostImages::class,'id_post');
    }

    public function competition(){
        return $this->belongsTo(Competitions::class,'id_competition');
    }

    public function category(){
        return $this->belongsTo(Category::class,'id_category');
    }
}
