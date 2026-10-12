<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Pages\RelationManagers\PageListRelationManager;
use App\Models\PageList;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageListRelationManagerTest extends TestCase
{
    #[DataProvider('contentProvider')]
    public function test_view_renders_rich_content_in_each_language(string $locale, string|array|null $content, ?string $expected): void
    {
        $entry = $this->contentEntry($locale, $content);

        if ($expected === null) {
            $this->assertNull($entry->getState());
            $this->assertStringContainsString('-', $entry->toHtml());

            return;
        }

        $this->assertIsString($entry->getState());
        $this->assertStringContainsString($expected, $entry->toHtml());
        $this->assertStringNotContainsString('&lt;p&gt;', $entry->toHtml());
    }

    public static function contentProvider(): iterable
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            yield "{$locale}: TipTap JSON" => [$locale, [
                'type' => 'doc',
                'content' => [[
                    'type' => 'paragraph',
                    'content' => [[
                        'type' => 'text',
                        'text' => 'Текст записи',
                        'marks' => [['type' => 'bold']],
                    ]],
                ]],
            ], '<strong>Текст записи</strong>'];
            yield "{$locale}: legacy HTML" => [$locale, '<p><strong>Старый текст</strong></p>', '<strong>Старый текст</strong>'];
            yield "{$locale}: null" => [$locale, null, null];
            yield "{$locale}: empty string" => [$locale, '', null];
        }
    }

    public function test_view_sanitizes_rich_content(): void
    {
        $entry = $this->contentEntry('ru', '<p>Описание</p><script>alert(1)</script>');

        $html = $entry->toHtml();

        $this->assertStringContainsString('Описание', $html);
        $this->assertStringNotContainsString('<script', $html);
    }

    private function contentEntry(string $locale, string|array|null $content): TextEntry
    {
        $record = new PageList(["content_{$locale}" => $content]);
        $manager = new PageListRelationManager;
        $schema = $manager->infolist(Schema::make($manager)->record($record));
        $entry = $schema->getComponent(
            fn ($component): bool => $component instanceof TextEntry && $component->getName() === "content_{$locale}",
        );

        $this->assertInstanceOf(TextEntry::class, $entry);

        return $entry;
    }
}
