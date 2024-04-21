<?php

use App\Models\RecipeCategories;
use App\Models\Recipes;
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
        Schema::create(Recipes::table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('instructions');
            $table->foreignId('category_id')->constrained(RecipeCategories::table_name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Recipes::table_name);
    }
};
