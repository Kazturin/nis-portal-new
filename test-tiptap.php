<?php

require __DIR__ . '/vendor/autoload.php';

use Tiptap\Editor;
use App\Filament\Forms\Components\RichEditor\Extensions\CustomTableCell;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableRow;

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$json = json_encode([
    'type' => 'doc',
    'content' => [
        [
            'type' => 'table',
            'content' => [
                [
                    'type' => 'tableRow',
                    'content' => [
                        [
                            'type' => 'tableCell',
                            'attrs' => [
                                'backgroundColor' => '#ff0000'
                            ],
                            'content' => [
                                [
                                    'type' => 'paragraph',
                                    'content' => [
                                        ['type' => 'text', 'text' => 'Test']
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
]);

$editor = new Editor([
    'extensions' => [
        new CustomTableCell(),
        new Table(),
        new TableRow(),
        new \Tiptap\Nodes\Paragraph(),
        new \Tiptap\Nodes\Text(),
    ]
]);

echo $editor->setContent($json)->getHTML();
echo "\n";
