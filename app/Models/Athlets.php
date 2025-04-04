<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Athlets extends Model
{
    protected $fillable = ['fullName','age'];
    public $timestamps = false;
    use Filterable;

    public function premiant(){
        return $this->hasMany(Premiants::class,'id_athlet');
    }
}
