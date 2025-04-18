<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    const table_name = "recipes";
    protected $fillable = ['name', 'instructions', 'category_id','user_id'];
    

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function category()
    {
        return $this->belongsTo(RecipeCategorie::class, 'category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function images()
    {
        return $this->hasMany(RecipeImage::class);
    }

    public static function searchByIngredients($ingredients)
    {
        return static::whereHas('ingredients', function ($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhere('name', 'like', '%' . $ingredient . '%');
            }
        })->get();
    }
    public function get_cover_image(){
        $image = $this->images()->orderByDesc('is_cover')->first();
        if (!$image) {
            return null;
        }
        return asset( "storage/".$image->image);
    }

}
