<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImages extends Model
{
    protected $fillable = ['image_path','post_id'];
    public $timestamps = false;

    public function post(){
        return $this->belongsTo(Posts::class,'id_post');
    }
}
