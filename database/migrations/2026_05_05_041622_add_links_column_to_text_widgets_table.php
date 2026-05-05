<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('text_widgets', function (Blueprint $table) {
            $table->string('link_kk')->after('content_en')->nullable();
            $table->string('link_ru')->after('link_kk')->nullable();
            $table->string('link_en')->after('link_ru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('text_widgets', function (Blueprint $table) {
            $table->dropColumn('link_kk');
            $table->dropColumn('link_ru');
            $table->dropColumn('link_en');
        });
    }
};
