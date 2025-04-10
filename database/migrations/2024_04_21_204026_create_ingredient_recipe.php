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
        Schema::create('ingredient_recepie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recepie_id')->constrained(Recepie::table_name);
            $table->foreignId('ingredient_id')->constrained(Ingredient::table_name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_recepie');
    }
};
