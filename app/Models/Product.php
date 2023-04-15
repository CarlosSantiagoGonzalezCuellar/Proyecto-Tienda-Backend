<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    //Relacion uno a muchos (inversa)
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
}
