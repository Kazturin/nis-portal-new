<?php

namespace App\Services\Page;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\RecognitionMapBlock;
use InvalidArgumentException;

class RecognitionMapImporter
{
    private const COUNTRY_CODES = [
        'AU' => ['Австралия', 'Australia'],
        'US' => ['США', 'АҚШ', 'USA'],
        'BE' => ['Бельгия', 'Belgium'],
        'DK' => ['Дания', 'Denmark'],
        'JP' => ['Япония', 'Жапония', 'Japan'],
        'IT' => ['Италия', 'Italy'],
        'CA' => ['Канада', 'Canada'],
        'KR' => ['Республика Корея', 'Корея Республикасы', 'Republic of Korea'],
        'CN' => ['КНР', 'ҚХР', 'PRC'],
        'LT' => ['Литва', 'Lithuania'],
        'NL' => ['Нидерланды', 'Netherlands'],
        'RU' => ['Россия', 'Ресей', 'Russia'],
        'SG' => ['Сингапур', 'Singapore'],
        'TR' => ['Турция', 'Түркия', 'Turkey'],
        'GB' => ['Великобритания', 'Ұлыбритания', 'United Kingdom'],
        'FI' => ['Финляндия', 'Finland'],
        'CH' => ['Швейцария', 'Switzerland'],
    ];

    public function convert(array $document, string $locale): array
    {
        foreach ($document['content'] ?? [] as $index => $node) {
            if (($node['attrs']['id'] ?? null) === RecognitionMapBlock::getId()) {
                $document['content'][$index]['attrs']['config'] = RecognitionMapBlock::normalizeConfig($node['attrs']['config'] ?? []);

                return $document;
            }
            if (($node['type'] ?? null) !== 'customBlock' || ($node['attrs']['id'] ?? null) !== 'accordion') {
                continue;
            }

            $countries = [];
            foreach ($node['attrs']['config']['items'] ?? [] as $group) {
                $code = $this->countryCode($group['title'] ?? '');
                foreach ($this->columns($group['content'] ?? []) as $column) {
                    $name = $this->text($column);
                    if ($name === '' || preg_match('/ACCA|присяжн|присяжд/ui', $name)) {
                        continue;
                    }
                    $entryCode = $code;
                    $countryName = $group['title'];
                    // These entries lived under the UK heading in the old accordion.
                    if ($code === 'GB' && preg_match('/Дублин|Dublin|Голуей|Голуэй|Galway/ui', $name)) {
                        $entryCode = 'IE';
                        $countryName = ['ru' => 'Ирландия', 'kk' => 'Ирландия', 'en' => 'Ireland'][$locale];
                    } elseif ($code === 'GB' && preg_match('/Казахстан|Қазақстан|Kazakhstan/ui', $name)) {
                        continue;
                    }
                    $countries[$entryCode] ??= ['code' => $entryCode, 'name' => $countryName, 'institutions' => []];
                    $countries[$entryCode]['institutions'][] = [
                        'name' => $name,
                        'logo' => $this->firstImage($column),
                        'url' => $this->firstLink($column),
                        'year' => null,
                        'basis' => '',
                    ];
                }
            }
            if ($countries === []) {
                throw new InvalidArgumentException('The recognition accordion contains no institutions.');
            }

            $description = '';
            $previous = $document['content'][$index - 1] ?? null;
            if (($previous['type'] ?? null) === 'paragraph') {
                $description = $this->text($previous);
                if ($description !== '') {
                    unset($document['content'][$index - 1]);
                }
            }
            $document['content'][$index] = [
                'type' => 'customBlock',
                'attrs' => [
                    'id' => RecognitionMapBlock::getId(),
                    'config' => ['title' => '', 'description' => $description, 'countries' => array_values($countries)],
                ],
            ];
            $document['content'] = array_values($document['content']);

            return $document;
        }

        throw new InvalidArgumentException('No recognition accordion was found.');
    }

    private function countryCode(string $name): string
    {
        foreach (self::COUNTRY_CODES as $code => $names) {
            if (in_array(trim($name), $names, true)) {
                return $code;
            }
        }

        throw new InvalidArgumentException("Unknown country: {$name}");
    }

    private function columns(array $node): array
    {
        if (($node['type'] ?? null) === 'gridColumn') {
            return [$node];
        }
        $columns = [];
        foreach ($node['content'] ?? [] as $child) {
            array_push($columns, ...$this->columns($child));
        }

        return $columns;
    }

    private function text(array $node): string
    {
        $text = $node['text'] ?? '';
        foreach ($node['content'] ?? [] as $child) {
            $text .= ' '.$this->text($child);
        }

        return trim(preg_replace('/\s+/u', ' ', $text));
    }

    private function firstImage(array $node): string
    {
        if (($node['type'] ?? null) === 'image') {
            return $node['attrs']['src'] ?? '';
        }
        foreach ($node['content'] ?? [] as $child) {
            if ($image = $this->firstImage($child)) {
                return $image;
            }
        }

        return '';
    }

    private function firstLink(array $node): string
    {
        foreach ($node['marks'] ?? [] as $mark) {
            if (($mark['type'] ?? null) === 'link' && filled($mark['attrs']['href'] ?? null)) {
                return $mark['attrs']['href'];
            }
        }
        foreach ($node['content'] ?? [] as $child) {
            if ($link = $this->firstLink($child)) {
                return $link;
            }
        }

        return '';
    }
}
