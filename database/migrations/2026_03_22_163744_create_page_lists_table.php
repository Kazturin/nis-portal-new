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
        Schema::create('page_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en')->nullable();
            $table->text('description_kk')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
            $table->text('content_kk')->nullable();
            $table->text('content_ru')->nullable();
            $table->text('content_en')->nullable();
            $table->unsignedBigInteger('page_id')->index('page_lists_page_id_foreign');
            $table->dateTime('date')->nullable();
            $table->tinyInteger('position')->default(0);
            $table->string('image')->nullable();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_lists');
    }
};
