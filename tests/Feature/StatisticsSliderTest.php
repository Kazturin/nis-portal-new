<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StatisticsSliderTest extends TestCase
{
    #[DataProvider('statisticCounts')]
    public function test_slider_renders_every_statistic_once_including_incomplete_and_additional_slides(int $count, int $expectedSlides): void
    {
        $statistics = collect(range(1, max(1, $count)))
            ->take($count)
            ->map(fn (int $index): object => (object) [
                'value' => "value-{$index}",
                'description' => "<strong>description-{$index}</strong>",
            ]);

        $html = Blade::render('<x-statistics-slider :statistics="$statistics" />', compact('statistics'));

        $this->assertSame($expectedSlides, substr_count($html, 'class="swiper-slide '));

        foreach ($statistics as $statistic) {
            $this->assertSame(1, substr_count($html, ">{$statistic->value}</p>"));
            $this->assertStringContainsString($statistic->description, $html);
        }

        if ($count === 0) {
            $this->assertSame('', trim($html));
        }

        if ($expectedSlides < 2) {
            $this->assertStringNotContainsString('statistics-swiper-button-next', $html);
        }
    }

    public static function statisticCounts(): iterable
    {
        foreach ([0 => 0, 1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 2, 6 => 2, 7 => 3, 8 => 3, 9 => 3, 10 => 4, 11 => 4, 12 => 5, 22 => 8, 23 => 9] as $count => $slides) {
            yield "{$count} statistics" => [$count, $slides];
        }
    }

    public function test_statistic_values_are_escaped(): void
    {
        $html = Blade::render('<x-statistics-slider :statistics="$statistics" />', [
            'statistics' => collect([(object) ['value' => '<b>100</b>', 'description' => 'Description']]),
        ]);

        $this->assertStringContainsString('&lt;b&gt;100&lt;/b&gt;', $html);
        $this->assertStringNotContainsString('<b>100</b>', $html);
    }

    #[DataProvider('optionalValues')]
    public function test_optional_values_keep_descriptions_visible_in_every_layout(?string $value, int $expectedValueCount): void
    {
        $statistics = collect(range(1, 11))->map(fn (int $index): object => (object) [
            'value' => $value,
            'description' => "<strong>description-{$index}</strong>",
        ]);

        $html = Blade::render('<x-statistics-slider :statistics="$statistics" />', compact('statistics'));

        $this->assertSame($expectedValueCount, preg_match_all('/<p(?:\s|>)/', $html));

        foreach ($statistics as $statistic) {
            $this->assertStringContainsString($statistic->description, $html);
        }
    }

    public static function optionalValues(): iterable
    {
        yield 'null' => [null, 0];
        yield 'empty string' => ['', 0];
        yield 'zero' => ['0', 11];
    }
}
