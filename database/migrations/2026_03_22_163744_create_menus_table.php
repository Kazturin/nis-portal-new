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
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en');
            $table->string('slug')->nullable();
            $table->string('link_kk')->nullable();
            $table->string('link_ru')->nullable();
            $table->string('link_en')->nullable();
            $table->boolean('is_external_link')->default(false);
            $table->tinyInteger('sort')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable()->index('menus_parent_id_foreign');
            $table->boolean('active')->default(true);
            $table->boolean('is_product')->default(false);
            $table->string('banner')->nullable();
            $table->boolean('open_in_new_tab')->nullable();
            $table->boolean('is_alumni')->default(false);
            $table->tinyInteger('position')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
