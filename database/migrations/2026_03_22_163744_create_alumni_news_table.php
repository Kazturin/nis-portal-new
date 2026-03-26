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
        Schema::create('alumni_news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page_id')->index('alumni_news_page_id_foreign');
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en');
            $table->longText('content_kk');
            $table->longText('content_ru');
            $table->longText('content_en');
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->boolean('active');
            $table->json('gallery')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_news');
    }
};
