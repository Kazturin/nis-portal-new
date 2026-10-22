<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->string('value', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('statistics')->whereNull('value')->update(['value' => '']);

        Schema::table('statistics', function (Blueprint $table) {
            $table->string('value', 20)->nullable(false)->change();
        });
    }
};
