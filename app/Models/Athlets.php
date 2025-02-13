<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlets extends Model
{
    protected $fillable = ['fullName','age','weight','place'];
    public $timestamps = false;
    public function competition(){
        return $this->belongsTo(Competitions::class,'id_competition');
    }
}
