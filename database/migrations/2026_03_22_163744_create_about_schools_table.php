<?php

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
        Schema::create('about_schools', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->text('mission_kk');
            $table->text('mission_ru');
            $table->text('mission_en');
            $table->text('vision_kk');
            $table->text('vision_ru');
            $table->text('vision_en');
            $table->text('valuables_kk');
            $table->text('valuables_ru');
            $table->text('valuables_en');
            $table->unsignedBigInteger('school_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_schools');
    }
};
