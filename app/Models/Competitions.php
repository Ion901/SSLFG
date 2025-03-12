<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Competitions extends Model
{
    protected $fillable = ['name','location','date'];
    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime', // Ensures it's treated as a Carbon instance
    ];
    public function athlet(){
        return $this->hasMany(Premiants::class,'id_competition');
    }

    public function post(){
        return $this->hasOne(Posts::class,'id_competition');
    }

    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('Y-m-d') : null;
    }
}
