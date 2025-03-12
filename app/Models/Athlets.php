<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlets extends Model
{
    protected $fillable = ['fullName','age'];
    public $timestamps = false;

    public function premiant(){
        return $this->hasMany(Premiants::class,'id_athlet');
    }
}
