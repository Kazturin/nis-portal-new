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
        Schema::create('page_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_kk')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_ru')->nullable();
            $table->string('file_en')->nullable();
            $table->tinyInteger('position')->default(0);
            $table->unsignedBigInteger('page_id')->index('page_files_page_id_foreign');
            $table->timestamps();
            $table->string('thumbnail')->nullable();
            $table->json('files_kk')->nullable();
            $table->string('link_kk')->nullable();
            $table->string('link_ru')->nullable();
            $table->string('link_en')->nullable();
            $table->json('files_ru')->nullable();
            $table->json('files_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_files');
    }
};
