<?php

use App\Models\Ingredient;
use App\Models\Recepie;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredients_recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipes_id')->constrained(Recepie::table_name);
            $table->foreignId('ingredients_id')->constrained(Ingredient::table_name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients_recipes');
    }
};
