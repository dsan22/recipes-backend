<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeImage extends Model
{
    const table_name = "recipe_images";
    use HasFactory;

    public function recipe(){
        return $this->belongsTo(Recipe::class);
    }
    protected $guarded=['id'];
}
