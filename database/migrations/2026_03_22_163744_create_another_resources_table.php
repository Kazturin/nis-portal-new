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
        Schema::create('another_resources', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en');
            $table->text('description_kk');
            $table->text('description_ru');
            $table->text('description_en');
            $table->string('link')->nullable();
            $table->string('icon');
            $table->boolean('active');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('another_resources');
    }
};
