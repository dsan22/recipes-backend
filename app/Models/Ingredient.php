<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    const table_name = "ingredients";


    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
    
    //allows mass asigment for name
    protected $fillable = ['name'];
    
}
