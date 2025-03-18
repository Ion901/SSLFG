<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premiants extends Model
{
    protected $table = 'premiants';
    protected $fillable = ['fullName','age','weight','place','id_competition','id_athlet'];
    public $timestamps = false;

    public function competition(){
        return $this->belongsTo(Competitions::class,'id_competition');
    }

    public function athlet(){
        return $this->belongsTo(Athlets::class,'id_athlet');
    }
}
