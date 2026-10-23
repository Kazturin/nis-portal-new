<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class RecognitionMapBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'recognition_map';
    }

    public static function getLabel(): string
    {
        return 'Карта признания NIS';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action->modalWidth('5xl')
            ->fillForm(fn (array $arguments): array => static::normalizeConfig($arguments['config'] ?? []))
            ->mutateDataUsing(function (array $data, Action $action): array {
                $data = static::normalizeConfig($data);
                if (! static::hasInstitutions($data)) {
                    throw ValidationException::withMessages([
                        'mountedActions.'.$action->getNestingIndex().'.data.countries' => __('recognition-map.invalid_config'),
                    ]);
                }

                return $data;
            })
            ->schema([
                TextInput::make('title')->label('Заголовок')->maxLength(255),
                Textarea::make('description')->label('Описание')->rows(3),
                Repeater::make('countries')->label('Страны')->required()->minItems(1)->defaultItems(0)->schema([
                    Group::make([
                        TextInput::make('name')->label('Название страны')->required(),
                        Select::make('code')->label('Страна на карте')
                            ->options(collect(static::coordinates())->except('KZ')->map(fn (array $country): string => $country['name'])->all())
                            ->searchable()->required()->distinct(),
                    ])->columns(2),
                    Repeater::make('institutions')->label('Университеты')->required()->minItems(1)->defaultItems(0)->schema([
                        TextInput::make('name')->label('Название')->required(),
                        FileUpload::make('logo')->label('Логотип')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('pages/content/recognition-map/logos')
                            ->fetchFileInformation(false)
                            ->getUploadedFileUsing(fn (string $file): array => [
                                'name' => basename(parse_url($file, PHP_URL_PATH) ?: $file),
                                'size' => 0,
                                'type' => null,
                                'url' => static::logoUrl($file),
                            ]),
                        TextInput::make('url')->label('Ссылка на подтверждение')->maxLength(2048),
                        TextInput::make('year')->label('Год признания')->integer()->minValue(1900)->maxValue(2100),
                        Textarea::make('basis')->label('Основание признания')->rows(3),
                    ])->itemLabel(fn (array $state): ?string => $state['name'] ?? null)->collapsed(),
                ])->itemLabel(fn (array $state): ?string => $state['name'] ?? null)->collapsed(),
            ]);
    }

    public static function editorValidationRule(): Closure
    {
        return static function (string $attribute, mixed $value, Closure $fail): void {
            $validateNodes = function (array $nodes) use (&$validateNodes, $fail): void {
                foreach ($nodes as $node) {
                    if (($node['type'] ?? null) === 'customBlock'
                        && ($node['attrs']['id'] ?? null) === static::getId()
                        && ! static::hasInstitutions($node['attrs']['config'] ?? [])) {
                        $fail(__('recognition-map.invalid_config'));
                    }
                    $validateNodes($node['content'] ?? []);
                }
            };

            if (is_array($value)) {
                $validateNodes($value['content'] ?? []);
            }
        };
    }

    protected static function hasInstitutions(array $config): bool
    {
        return static::normalizeConfig($config)['countries'] !== [];
    }

    public static function normalizeConfig(array $config): array
    {
        // Normalize previously saved blocks before editing or rendering them.
        unset($config['foreign_universities_only']);
        $config['countries'] = collect($config['countries'] ?? [])
            ->filter(fn ($country): bool => is_array($country)
                && filled($country['code'] ?? null)
                && strtoupper(trim($country['code'])) !== 'KZ')
            ->map(function (array $country): array {
                $country['institutions'] = collect($country['institutions'] ?? [])
                    ->filter(fn ($item): bool => is_array($item)
                        && filled($item['name'] ?? null)
                        && ($item['type'] ?? 'university') !== 'organization')
                    ->map(function (array $item): array {
                        unset($item['type']);

                        return $item;
                    })->values()->all();

                return $country;
            })->filter(fn (array $country): bool => count($country['institutions']) > 0)
            ->values()->all();

        return $config;
    }

    public static function coordinates(): array
    {
        return json_decode(file_get_contents(resource_path('data/recognition-map-countries.json')), true, flags: JSON_THROW_ON_ERROR);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.recognition-map.preview', static::viewData($config))->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.recognition-map.index', static::viewData($config))->render();
    }

    protected static function safeUrl(?string $url): string
    {
        $url = trim($url ?? '');

        return preg_match('~^(https?://|/(?!/))~i', $url) ? $url : '';
    }

    protected static function logoUrl(?string $logo): string
    {
        $logo = trim($logo ?? '');

        if ($logo === '' || str_starts_with($logo, '/') || preg_match('~^[a-z][a-z0-9+.-]*:~i', $logo)) {
            return static::safeUrl($logo);
        }

        return Storage::disk('public')->url($logo);
    }

    protected static function viewData(array $config): array
    {
        $coordinates = static::coordinates();
        $config = static::normalizeConfig($config);
        $countries = collect($config['countries'])
            ->map(function (array $country) use ($coordinates): array {
                $code = strtoupper(trim($country['code']));
                $institutions = collect($country['institutions'] ?? [])
                    ->filter(fn ($item): bool => is_array($item) && filled($item['name'] ?? null))
                    ->map(fn (array $item): array => [
                        'name' => $item['name'],
                        'logo' => static::logoUrl($item['logo'] ?? null),
                        'url' => static::safeUrl($item['url'] ?? null),
                        'year' => $item['year'] ?? '',
                        'basis' => $item['basis'] ?? '',
                    ])->values();

                return [
                    'code' => $code,
                    'name' => $country['name'] ?? $coordinates[$code]['name'] ?? $code,
                    'x' => $coordinates[$code]['x'] ?? null,
                    'y' => $coordinates[$code]['y'] ?? null,
                    'institutions' => $institutions->all(),
                    'count' => $institutions->count(),
                ];
            })->sortByDesc('count')->values();

        return [
            'title' => $config['title'] ?? '',
            'description' => array_key_exists('description', $config) ? ($config['description'] ?? '') : __('recognition-map.description'),
            'countries' => $countries->all(),
            'total' => $countries->sum('count'),
            'foreignCountries' => $countries->pluck('code')->unique()->count(),
        ];
    }
}
