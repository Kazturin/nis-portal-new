<?php

namespace Tests\Feature\Filament;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\BannerCardBlock;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BannerCardBlockTest extends TestCase
{
    #[DataProvider('locales')]
    public function test_page_renders_banner_with_formatted_description_in_each_language(string $locale): void
    {
        $page = new Page([
            "content_{$locale}" => [
                'type' => 'doc',
                'content' => [[
                    'type' => 'customBlock',
                    'attrs' => [
                        'id' => 'banner_card',
                        'config' => [
                            'background_image' => 'pages/content/banners/background.jpg',
                            'icon' => 'pages/content/banners/icons/logo.png',
                            'title' => 'Таза Казахстан <инициатива>',
                            'description' => [
                                'type' => 'doc',
                                'content' => [[
                                    'type' => 'paragraph',
                                    'content' => [[
                                        'type' => 'text',
                                        'text' => 'Экологическая инициатива',
                                        'marks' => [['type' => 'bold']],
                                    ]],
                                ]],
                            ],
                            'title_color' => '#245522',
                            'text_color' => '#31572E',
                        ],
                    ],
                ]],
            ],
        ]);

        $html = $page->renderRichContent("content_{$locale}");

        $this->assertStringContainsString(Storage::disk('public')->url('pages/content/banners/background.jpg'), $html);
        $this->assertStringContainsString(Storage::disk('public')->url('pages/content/banners/icons/logo.png'), $html);
        $this->assertStringContainsString('Таза Казахстан &lt;инициатива&gt;', $html);
        $this->assertStringContainsString('<strong>Экологическая инициатива</strong>', $html);
        $this->assertStringContainsString('--banner-title-color: #245522', $html);
        $this->assertStringContainsString('--banner-text-color: #31572E', $html);
    }

    public static function locales(): iterable
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            yield $locale => [$locale];
        }
    }

    public function test_banner_and_preview_render_without_optional_icon_and_description(): void
    {
        $config = [
            'background_image' => 'pages/content/banners/background.jpg',
            'title' => 'Таза Казахстан',
        ];

        $html = BannerCardBlock::toHtml($config, []);

        $this->assertStringContainsString('Таза Казахстан', $html);
        $this->assertStringNotContainsString('banner-card__icon', $html);
        $this->assertStringNotContainsString('banner-card__description', $html);
        $this->assertSame($html, BannerCardBlock::toPreviewHtml($config));
    }

    public function test_description_is_sanitized_when_rendering_legacy_html(): void
    {
        $html = BannerCardBlock::toHtml([
            'title' => 'Таза Казахстан',
            'description' => '<p>Описание</p><script>alert(1)</script>',
        ], []);

        $this->assertStringContainsString('<p>Описание</p>', $html);
        $this->assertStringNotContainsString('<script', $html);
    }
}
