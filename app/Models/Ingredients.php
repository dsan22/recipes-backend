<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    use HasFactory;

    const table_name = "ingredients";


    public function recipes()
    {
        return $this->belongsToMany(Recipes::class);
    }
    
    //allows mass asigment for name
    protected $fillables = ['name'];
    
}
