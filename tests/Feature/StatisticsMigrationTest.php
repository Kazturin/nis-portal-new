<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StatisticsMigrationTest extends TestCase
{
    public function test_migration_preserves_existing_display_order_and_clears_old_caches(): void
    {
        $originalConnection = DB::getDefaultConnection();
        config(['database.connections.statistics_migration' => ['driver' => 'sqlite', 'database' => ':memory:']]);
        DB::setDefaultConnection('statistics_migration');

        try {
            $originalMigration = require database_path('migrations/2026_03_22_163744_create_statistics_table.php');
            $originalMigration->up();

            foreach (['2702', 'custom', '17 884'] as $value) {
                DB::table('statistics')->insert([
                    'value' => $value,
                    'description_kk' => 'KK',
                    'description_ru' => 'RU',
                    'description_en' => 'EN',
                ]);
            }

            foreach (['kk', 'ru', 'en'] as $locale) {
                Cache::put("statistics_{$locale}", ['stale']);
                Cache::put("homepage_html_{$locale}", 'stale');
            }

            $migration = require database_path('migrations/2026_10_22_000000_add_sort_to_statistics_table.php');
            $migration->up();

            $this->assertSame(['17 884' => 1, '2702' => 4, 'custom' => 12], DB::table('statistics')->orderBy('sort')->pluck('sort', 'value')->all());

            foreach (['kk', 'ru', 'en'] as $locale) {
                $this->assertFalse(Cache::has("statistics_{$locale}"));
                $this->assertFalse(Cache::has("homepage_html_{$locale}"));
            }

            $migration->down();

            $this->assertFalse(Schema::hasColumn('statistics', 'sort'));
            $this->assertSame(3, DB::table('statistics')->count());
        } finally {
            DB::purge('statistics_migration');
            DB::setDefaultConnection($originalConnection);
        }
    }
}
