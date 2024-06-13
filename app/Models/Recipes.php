<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipes extends Model
{
    use HasFactory;

    const table_name = "recipes";
    protected $fillable = ['name', 'instructions', 'category_id','user_id'];
    

    public function ingredients()
    {
        return $this->belongsToMany(Ingredients::class);
    }

    public function category()
    {
        return $this->belongsTo(RecipeCategories::class, 'category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function searchByIngredients($ingredients)
    {
        return static::whereHas('ingredients', function ($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhere('name', 'like', '%' . $ingredient . '%');
            }
        })->get();
    }

    
}
