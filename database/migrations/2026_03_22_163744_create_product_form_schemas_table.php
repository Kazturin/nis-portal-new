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
        Schema::create('product_form_schemas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('product_form_schemas_product_id_foreign');
            $table->json('form_schema')->nullable();
            $table->string('title_kk');
            $table->string('title_ru');
            $table->string('title_en');
            $table->string('submit_label_kk');
            $table->string('submit_label_ru');
            $table->string('submit_label_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_form_schemas');
    }
};
