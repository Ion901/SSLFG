<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Premiants extends Model
{
    protected $table = 'premiants';
    protected $fillable = ['fullName','age','weight','place','id_competition','id_athlet'];
    public $timestamps = false;
    use Filterable;

    public function competition(){
        return $this->belongsTo(Competitions::class,'id_competition');
    }

    public function athlet(){
        return $this->belongsTo(Athlets::class,'id_athlet');
    }

    public function fullName(){
        return $this->athlet->fullName; // Access the accessor defined in Athlets model
    }
    public function age(){
        return $this->athlet->age; // Access the accessor defined in Athlets model
    }
    public function competitionName(){
        return $this->competition->name; // Access the accessor defined in Athlets model
    }
}
