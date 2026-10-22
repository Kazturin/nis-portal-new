<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->unsignedInteger('sort')->default(0);
        });

        // Preserve the display order from the original homepage template.
        $originalValues = [
            '17 884', '1891 / 11%', '5 985 / 38,4%', '2702',
            '20 771', '220', '7,0', '348 465', '91,8 %', '22', '1299',
        ];
        $nextPosition = count($originalValues) + 1;

        foreach (DB::table('statistics')->orderBy('id')->get(['id', 'value']) as $statistic) {
            $originalPosition = array_search($statistic->value, $originalValues, true);

            DB::table('statistics')->where('id', $statistic->id)->update([
                'sort' => $originalPosition === false ? $nextPosition++ : $originalPosition + 1,
            ]);
        }

        $this->clearStatisticsCache();
    }

    public function down(): void
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->dropColumn('sort');
        });

        $this->clearStatisticsCache();
    }

    private function clearStatisticsCache(): void
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            Cache::forget("statistics_{$locale}");
            Cache::forget("homepage_html_{$locale}");
        }
    }
};
