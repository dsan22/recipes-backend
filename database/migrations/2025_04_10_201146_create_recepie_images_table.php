<?php

use App\Models\RecepieImage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Recepie;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(RecepieImage::table_name, function (Blueprint $table) {
            $table->id();
            $table->foreignId('recepie_id')->constrained(Recepie::table_name);
            $table->string('image');
            $table->boolean('is_cover')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(RecepieImage::table_name);
    }
};
