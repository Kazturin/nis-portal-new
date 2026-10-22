<?php

namespace Tests\Feature;

use App\Models\Statistic;
use App\Services\Page\HomePageDataFetcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('locales')]
    public function test_statistics_keep_duplicate_values_and_follow_the_configured_order(string $locale): void
    {
        app()->setLocale($locale);
        $last = Statistic::factory()->create(['value' => '100', 'sort' => 2]);
        $first = Statistic::factory()->create(['value' => '100', 'sort' => 1]);
        $tied = Statistic::factory()->create(['value' => '300', 'sort' => 2]);

        $fetcher = new HomePageDataFetcher;

        foreach (range(1, 2) as $attempt) {
            $statistics = $fetcher->getStatistics();

            $this->assertSame([$first->id, $last->id, $tied->id], $statistics->pluck('id')->all());
            $this->assertSame($first->{"description_{$locale}"}, $statistics->first()->description);
        }

        $first->update(['value' => 'Новое значение', 'sort' => 3]);
        $statistics = $fetcher->getStatistics();

        $this->assertSame([$last->id, $tied->id, $first->id], $statistics->pluck('id')->all());
        $this->assertSame('Новое значение', $statistics->last()->value);

        $last->delete();
        $this->assertCount(2, $fetcher->getStatistics());
    }

    public static function locales(): iterable
    {
        yield ['kk'];
        yield ['ru'];
        yield ['en'];
    }
}
