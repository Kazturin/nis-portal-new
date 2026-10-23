<?php

namespace Tests\Feature\Filament;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\RecognitionMapBlock;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Models\Page;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RecognitionMapSavingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $user = User::factory()->create();
        $user->assignRole(Role::findOrCreate('admin', 'web'));
        $this->actingAs($user);
    }

    #[DataProvider('descriptionEdits')]
    public function test_editing_description_and_saving_the_page_preserves_countries(string $locale, string $description): void
    {
        $config = $this->config();
        $document = $this->document($config);
        $page = Page::factory()->create([
            'content_kk' => $document, 'content_ru' => $document, 'content_en' => $document,
        ]);
        $updatedDocument = null;
        $editor = Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->mountAction($this->editAction($locale, $config))
            ->set('mountedActions.0.data.description', $description)
            ->callMountedAction()
            ->assertHasNoActionErrors()
            ->assertDispatched('run-rich-editor-commands', function (string $name, array $params) use ($config, $description, &$updatedDocument): bool {
                $node = $params['commands'][0]['arguments'][0];
                $this->assertSame($description, $node['attrs']['config']['description'] ?? '');
                $this->assertEquals($config['countries'], $node['attrs']['config']['countries']);
                $updatedDocument = ['type' => 'doc', 'content' => [$node]];

                return true;
            });

        $this->assertNotNull($updatedDocument);
        // The browser applies the dispatched TipTap command before submitting the page.
        $editor->set("data.content_{$locale}", $updatedDocument)
            ->call('save')
            ->assertHasNoFormErrors();
        $page->refresh();
        $saved = $page->{"content_{$locale}"}['content'][0]['attrs'];
        $this->assertSame('recognition_map', $saved['id']);
        $this->assertEquals($config['countries'], $saved['config']['countries']);
        $this->assertSame($description, $saved['config']['description'] ?? '');
        foreach (array_diff(['kk', 'ru', 'en'], [$locale]) as $otherLocale) {
            $this->assertEquals($config, $page->{"content_{$otherLocale}"}['content'][0]['attrs']['config']);
        }

        $reopened = Livewire::test(EditPage::class, ['record' => $page->getRouteKey()]);
        $hydrated = $reopened->get('data')["content_{$locale}"]['content'][0]['attrs'];
        $this->assertNotEmpty($hydrated['config']);
        $this->assertNotEmpty($hydrated['label']);
        $reopened->mountAction($this->editAction($locale, $saved['config']))
            ->assertActionDataSet(['description' => $description === '' ? null : $description]);
    }

    public static function descriptionEdits(): iterable
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            yield "{$locale}: clear description" => [$locale, ''];
            yield "{$locale}: change description" => [$locale, 'Updated description'];
        }
    }

    public function test_empty_action_payload_cannot_replace_the_existing_configuration(): void
    {
        $config = $this->config();
        $page = Page::factory()->create(['content_kk' => $this->document($config)]);
        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->mountAction($this->editAction('kk', $config))
            ->set('mountedActions.0.data', [])
            ->callMountedAction()
            ->assertHasActionErrors(['countries' => 'required'])
            ->assertNotDispatched('run-rich-editor-commands');
        $this->assertEquals($config, $page->fresh()->content_kk['content'][0]['attrs']['config']);
    }

    public function test_page_save_rejects_a_block_with_empty_configuration(): void
    {
        $config = $this->config();
        $page = Page::factory()->create(['content_kk' => $this->document($config)]);
        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->set('data.content_kk', $this->document([]))
            ->call('save')
            ->assertHasFormErrors(['content_kk']);
        $this->assertEquals($config, $page->fresh()->content_kk['content'][0]['attrs']['config']);
    }

    public function test_logo_can_be_replaced_uploaded_and_removed_without_losing_universities(): void
    {
        Storage::fake('public');
        $config = $this->config();
        $page = Page::factory()->create(['content_kk' => $this->document($config)]);
        $uploadedLogo = null;

        $editor = Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->mountAction($this->editAction('kk', $config));
        $logoField = $editor->instance()->getSchema('mountedActionSchema0')
            ->getComponent(fn ($component): bool => $component instanceof FileUpload && $component->getName() === 'logo');
        $this->assertInstanceOf(FileUpload::class, $logoField);
        $this->assertSame('/storage/logo.png', array_values($logoField->getUploadedFiles())[0]['url']);
        $logoStatePath = $logoField->getStatePath();

        $editor->set($logoStatePath, [])
            ->set($logoStatePath, [UploadedFile::fake()->image('new-logo.png', 200, 100)])
            ->callMountedAction()
            ->assertHasNoActionErrors()
            ->assertDispatched('run-rich-editor-commands', function (string $name, array $params) use ($config, &$uploadedLogo): bool {
                $saved = $params['commands'][0]['arguments'][0]['attrs']['config'];
                $uploadedLogo = $saved['countries'][0]['institutions'][0]['logo'];
                $this->assertStringStartsWith('pages/content/recognition-map/logos/', $uploadedLogo);
                Storage::disk('public')->assertExists($uploadedLogo);
                $this->assertCount(2, $saved['countries']);
                $this->assertEquals($config['countries'][1], $saved['countries'][1]);

                return true;
            });

        $config['countries'][0]['institutions'][0]['logo'] = $uploadedLogo;
        $editor->set('data.content_kk', $this->document($config))->call('save')->assertHasNoFormErrors();
        $this->assertSame($uploadedLogo, $page->fresh()->content_kk['content'][0]['attrs']['config']['countries'][0]['institutions'][0]['logo']);
        $renderedCountries = [];
        View::composer('filament.forms.components.rich-editor.rich-content-custom-blocks.recognition-map.index',
            function ($view) use (&$renderedCountries): void {
                $renderedCountries = $view->getData()['countries'];
            });
        RecognitionMapBlock::toHtml($config, []);
        $this->assertSame(Storage::disk('public')->url($uploadedLogo), $renderedCountries[0]['institutions'][0]['logo']);

        $editor->mountAction($this->editAction('kk', $config));
        $logoField = $editor->instance()->getSchema('mountedActionSchema0')
            ->getComponent(fn ($component): bool => $component instanceof FileUpload && $component->getName() === 'logo');
        $this->assertSame(Storage::disk('public')->url($uploadedLogo), array_values($logoField->getUploadedFiles())[0]['url']);
        $editor->set($logoField->getStatePath(), [])
            ->callMountedAction()
            ->assertHasNoActionErrors()
            ->assertDispatched('run-rich-editor-commands', function (string $name, array $params): bool {
                $saved = $params['commands'][0]['arguments'][0]['attrs']['config'];
                $this->assertEmpty($saved['countries'][0]['institutions'][0]['logo']);
                $this->assertCount(2, $saved['countries']);

                return true;
            });
        Storage::disk('public')->assertExists($uploadedLogo);
    }

    private function editAction(string $locale, array $config): TestAction
    {
        return TestAction::make('customBlock')->schemaComponent("content_{$locale}")->arguments([
            'id' => 'recognition_map', 'mode' => 'edit', 'config' => $config,
            'editorSelection' => ['type' => 'node', 'anchor' => 0],
        ]);
    }

    private function document(array $config): array
    {
        return ['type' => 'doc', 'content' => [[
            'type' => 'customBlock', 'attrs' => ['id' => 'recognition_map', 'config' => $config],
        ]]];
    }

    private function config(): array
    {
        return ['title' => 'Test map', 'description' => 'Old description', 'countries' => [
            ['code' => 'GB', 'name' => 'United Kingdom', 'institutions' => [
                ['name' => 'University of Cambridge', 'logo' => '/storage/logo.png', 'url' => 'https://example.org/recognition', 'year' => 2020, 'basis' => 'Recognition agreement'],
            ]],
            ['code' => 'IE', 'name' => 'Ireland', 'institutions' => [
                ['name' => 'University College Dublin', 'logo' => 'https://logos.example.org/dublin.png', 'url' => 'https://example.org/dublin', 'year' => 2021, 'basis' => 'Admission requirements'],
            ]],
        ]];
    }
}
