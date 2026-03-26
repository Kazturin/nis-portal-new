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
        Schema::create('alumni_menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_external_link')->default(false);
            $table->tinyInteger('sort')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable()->index('alumni_menus_parent_id_foreign');
            $table->boolean('active')->default(true);
            $table->string('banner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_menus');
    }
};
