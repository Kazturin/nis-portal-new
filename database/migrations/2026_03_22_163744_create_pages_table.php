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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en');
            $table->text('content_kk');
            $table->text('content_ru');
            $table->text('content_en');
            $table->string('slug');
            $table->unsignedBigInteger('menu_id')->index('pages_menu_id_foreign');
            $table->unsignedBigInteger('parent_id')->nullable()->index('pages_parent_id_foreign');
            $table->boolean('active')->default(true);
            $table->boolean('is_protected')->default(false);
            $table->string('lists_view_type', 10)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->default(1)->index('pages_created_by_foreign');
            $table->unsignedBigInteger('updated_by')->default(1)->index('pages_updated_by_foreign');

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
        Schema::dropIfExists('pages');
    }
};
