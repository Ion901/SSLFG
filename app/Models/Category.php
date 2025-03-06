<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['type'];
    public $timestamps = false;

    public function post(){
        return $this->hasMany(Posts::class,'id_category');
    }
}
