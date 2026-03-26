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
        Schema::table('alumni_pages', function (Blueprint $table) {
            $table->foreign(['menu_id'], 'fk_menu_id')->references(['id'])->on('menus')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni_pages', function (Blueprint $table) {
            $table->dropForeign('fk_menu_id');
        });
    }
};
