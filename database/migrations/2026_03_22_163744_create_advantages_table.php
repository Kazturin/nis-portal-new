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
        Schema::create('advantages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en');
            $table->text('text_kk');
            $table->text('text_ru');
            $table->text('text_en');
            $table->string('thumbnail');
            $table->tinyInteger('sort')->default(0);
            $table->boolean('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advantages');
    }
};
