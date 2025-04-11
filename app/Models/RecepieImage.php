<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepieImage extends Model
{
    const table_name = "recepie_images";
    use HasFactory;

    public function recepie(){
        return $this->belongsTo(Recepie::class);
    }
    protected $guarded=['id'];
}
