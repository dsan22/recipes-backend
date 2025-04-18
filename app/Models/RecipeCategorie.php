<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeCategorie extends Model
{
    use HasFactory;
    const table_name = "recipe_categories";
    protected $fillable=['name'];
}
