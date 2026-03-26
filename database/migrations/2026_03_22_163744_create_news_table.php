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
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en')->nullable();
            $table->longText('content_kk')->nullable();
            $table->longText('content_ru');
            $table->longText('content_en')->nullable();
            $table->string('slug')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->boolean('active');
            $table->json('gallery')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('category_id')->default(1)->index('news_category_id_foreign');

            $table->fullText(['title_en', 'content_en'], 'search_en');
            $table->fullText(['title_kk', 'content_kk'], 'search_kz');
            $table->fullText(['title_ru', 'content_ru'], 'search_ru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
