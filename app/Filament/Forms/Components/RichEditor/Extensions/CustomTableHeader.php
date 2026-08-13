<?php

namespace App\Filament\Forms\Components\RichEditor\Extensions;

use Tiptap\Nodes\TableHeader;

class CustomTableHeader extends TableHeader
{
    public function addAttributes()
    {
        return array_merge(parent::addAttributes(), [
            'backgroundColor' => [
                'parseHTML' => function ($DOMNode) {
                    return $DOMNode->getAttribute('data-bg-color') ?: null;
                },
                'renderHTML' => function ($attributes) {
                    if (! isset($attributes->backgroundColor) || empty($attributes->backgroundColor)) {
                        return null;
                    }

                    return [
                        'data-bg-color' => $attributes->backgroundColor,
                        'style' => 'background-color: ' . $attributes->backgroundColor,
                    ];
                },
            ],
        ]);
    }
}
