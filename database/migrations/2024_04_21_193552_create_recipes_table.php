<?php

use App\Models\RecepieCategorie;
use App\Models\Recepie;
use App\Models\User;
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
        Schema::create(Recepie::table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('instructions');
            $table->foreignId('category_id')->constrained(RecepieCategorie::table_name);
            $table->foreignId('user_id')->constrained(User::table_name);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Recepie::table_name);
    }
};
