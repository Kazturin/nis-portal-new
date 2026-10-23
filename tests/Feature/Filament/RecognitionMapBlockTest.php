<?php

namespace Tests\Feature\Filament;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\RecognitionMapBlock;
use App\Models\Page;
use App\Services\Page\RecognitionMapImporter;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RecognitionMapBlockTest extends TestCase
{
    #[DataProvider('locales')]
    public function test_page_renders_recognition_block_in_each_language(string $locale): void
    {
        app()->setLocale($locale);
        $page = new Page([
            "content_{$locale}" => [
                'type' => 'doc',
                'content' => [[
                    'type' => 'customBlock',
                    'attrs' => ['id' => 'recognition_map', 'config' => $this->config()],
                ]],
            ],
        ]);
        $html = $page->renderRichContent("content_{$locale}");
        $this->assertStringContainsString('nisRecognitionMap', $html);
        $this->assertStringContainsString('recognition-world-map.svg', $html);
        $this->assertStringContainsString($this->config()['title'], $html);
        $this->assertStringContainsString('Test University', $html);
        $this->assertStringNotContainsString('recognition-map.total', $html);
        $this->assertStringNotContainsString('worldMap(', $html);
    }

    public static function locales(): iterable
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            yield $locale => [$locale];
        }
    }

    public function test_counts_include_only_nonempty_universities_and_countries(): void
    {
        $html = RecognitionMapBlock::toPreviewHtml($this->config());
        $this->assertMatchesRegularExpression('/<strong>2<\/strong>\s*<span>'.preg_quote(__('recognition-map.total'), '/').'/', $html);
        $this->assertMatchesRegularExpression('/<strong>2<\/strong>\s*<span>'.preg_quote(__('recognition-map.countries'), '/').'/', $html);
        $this->assertSame(2, substr_count($html, 'class="nis-recognition-map__stat"'));
        $this->assertStringNotContainsString('nisRecognitionMap(', $html);
    }

    public function test_empty_config_and_untrusted_content_render_safely(): void
    {
        $this->assertStringContainsString(__('recognition-map.no_countries'), RecognitionMapBlock::toHtml([], []));
        $config = $this->config();
        $config['title'] = '<script>alert(1)</script>';
        $config['countries'][0]['institutions'][0]['url'] = 'javascript:alert(1)';
        $config['countries'][0]['institutions'][0]['logo'] = '//untrusted.example/logo.png';
        $html = RecognitionMapBlock::toHtml($config, []);
        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringNotContainsString('//untrusted.example', $html);
    }

    public function test_cleared_optional_text_does_not_reappear_as_default_text(): void
    {
        foreach (['title' => 'title', 'description' => 'intro'] as $field => $class) {
            foreach (['', null] as $value) {
                $html = RecognitionMapBlock::toHtml([...$this->config(), $field => $value], []);
                $preview = RecognitionMapBlock::toPreviewHtml([...$this->config(), $field => $value]);
                $this->assertStringNotContainsString('nis-recognition-map__'.$class, $html);
                $this->assertStringNotContainsString('nis-recognition-map__'.$class, $preview);
                $this->assertStringNotContainsString(__('recognition-map.'.$field), $html);
            }
        }
        $this->assertStringContainsString(__('recognition-map.description'), RecognitionMapBlock::toHtml($this->config(), []));
    }

    public function test_legacy_blocks_are_normalized_to_foreign_universities(): void
    {
        $config = $this->config();
        $config['foreign_universities_only'] = false;
        $config['countries'][] = ['code' => 'KZ', 'name' => 'Kazakhstan', 'institutions' => [['name' => 'Domestic University']]];
        $config['countries'][0]['institutions'][] = ['name' => 'ACCA', 'type' => 'organization'];
        $normalized = RecognitionMapBlock::normalizeConfig($config);
        $this->assertArrayNotHasKey('foreign_universities_only', $normalized);
        $this->assertCount(2, $normalized['countries']);
        $this->assertCount(1, $normalized['countries'][0]['institutions']);
        $html = RecognitionMapBlock::toHtml($config, []);
        $this->assertStringContainsString('Another University', $html);
        $this->assertStringNotContainsString('Domestic University', $html);
        $this->assertStringNotContainsString('ACCA', $html);
        $this->assertStringNotContainsString('Kazakhstan', $html);
        $this->assertMatchesRegularExpression('/<strong>2<\/strong>\s*<span>'.preg_quote(__('recognition-map.total'), '/').'/', $html);
    }

    public function test_import_preserves_names_logos_links_and_other_content_and_is_idempotent(): void
    {
        $column = fn (string $name): array => ['type' => 'gridColumn', 'content' => [
            ['type' => 'paragraph', 'content' => [
                ['type' => 'image', 'attrs' => ['src' => '/storage/logo.png']],
                ['type' => 'text', 'text' => $name, 'marks' => [['type' => 'link', 'attrs' => ['href' => 'https://example.org/admissions']]]],
            ]],
        ]];
        $document = ['type' => 'doc', 'content' => [
            ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Original introduction']]],
            ['type' => 'customBlock', 'attrs' => ['id' => 'accordion', 'config' => ['items' => [[
                'title' => 'United Kingdom', 'content' => ['type' => 'doc', 'content' => [
                    ['type' => 'grid', 'content' => [
                        $column('University of Cambridge'),
                        $column('University College Dublin'),
                        $column('University of Galway (Ireland)'),
                        $column('Coventry University Kazakhstan'),
                        $column('Association of Chartered Certified Accountants (ACCA)'),
                        ['type' => 'gridColumn', 'content' => [['type' => 'paragraph']]],
                    ]],
                ]],
            ]]]]],
            ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Keep this footer']]],
        ]];
        $importer = new RecognitionMapImporter;
        $converted = $importer->convert($document, 'en');
        $config = $converted['content'][0]['attrs']['config'];
        $this->assertSame('recognition_map', $converted['content'][0]['attrs']['id']);
        $this->assertSame('Original introduction', $config['description']);
        $countries = collect($config['countries'])->keyBy('code');
        $this->assertCount(2, $countries['IE']['institutions']);
        $this->assertArrayNotHasKey('KZ', $countries->all());
        $this->assertCount(1, $countries['GB']['institutions']);
        $entries = $countries->flatMap(fn (array $country): array => $country['institutions']);
        $this->assertCount(3, $entries);
        foreach ($entries as $entry) {
            $this->assertSame('/storage/logo.png', $entry['logo']);
            $this->assertSame('https://example.org/admissions', $entry['url']);
            $this->assertNull($entry['year']);
            $this->assertSame('', $entry['basis']);
        }
        $this->assertSame($document['content'][2], $converted['content'][1]);
        $this->assertSame($converted, $importer->convert($converted, 'en'));
    }

    public function test_import_refuses_to_drop_unrecognized_country_groups(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new RecognitionMapImporter)->convert(['content' => [[
            'type' => 'customBlock',
            'attrs' => ['id' => 'accordion', 'config' => ['items' => [['title' => 'Unknown country']]]],
        ]]], 'en');
    }

    private function config(): array
    {
        return ['title' => 'Recognition map', 'countries' => [
            ['code' => 'GB', 'name' => 'United Kingdom', 'institutions' => [
                ['name' => 'Test University', 'year' => 2020, 'basis' => 'Recognition agreement'],
                ['name' => ''],
            ]],
            ['code' => 'IE', 'name' => 'Ireland', 'institutions' => [
                ['name' => 'Another University'],
            ]],
        ]];
    }
}
