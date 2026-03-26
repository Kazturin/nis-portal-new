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
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('banner_ru');
            $table->string('banner_kk');
            $table->string('banner_en')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
            $table->string('link_kk')->nullable();
            $table->string('link_ru')->nullable();
            $table->string('link_en')->nullable();
            $table->tinyInteger('position')->default(0);
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
