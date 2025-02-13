<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competitions extends Model
{
    protected $fillable = ['name','location','date'];
    public $timestamps = false;
    public function athlet(){
        return $this->hasMany(Athlets::class,'id_competition');
    }

    public function post(){
        return $this->hasOne(Posts::class,'id_competition');
    }
}
