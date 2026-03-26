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
        Schema::create('banners', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('banner');
            $table->string('banner_text_kk');
            $table->string('banner_text_ru');
            $table->string('banner_text_en');
            $table->string('banner_sub_text_kk');
            $table->string('banner_sub_text_ru');
            $table->string('banner_sub_text_en');
            $table->unsignedBigInteger('school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
