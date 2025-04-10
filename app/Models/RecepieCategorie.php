<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepieCategorie extends Model
{
    use HasFactory;
    const table_name = "recepie_categories";
    protected $fillable=['name'];
}
