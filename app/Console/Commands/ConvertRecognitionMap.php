<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Services\Page\RecognitionMapImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConvertRecognitionMap extends Command
{
    protected $signature = 'pages:convert-recognition-map {page=79} {--apply : Save the converted content after making a backup}';

    protected $description = 'Convert the existing recognition accordion into the interactive recognition map';

    public function handle(RecognitionMapImporter $importer): int
    {
        return DB::transaction(function () use ($importer): int {
            $page = Page::query()->lockForUpdate()->findOrFail($this->argument('page'));
            $attributes = ['content_ru', 'content_kk', 'content_en'];
            $original = $page->only($attributes);
            $converted = [];
            foreach (['ru', 'kk', 'en'] as $locale) {
                $attribute = "content_{$locale}";
                if (empty($page->{$attribute})) {
                    continue;
                }
                $converted[$attribute] = $importer->convert($page->{$attribute}, $locale);
                $this->info("{$locale}: content prepared");
            }
            if ($converted === [] || $converted === array_intersect_key($original, $converted)) {
                $this->info('No changes needed.');

                return self::SUCCESS;
            }
            if (! $this->option('apply')) {
                $this->info('Dry run complete. Use --apply to save.');

                return self::SUCCESS;
            }
            $backup = 'backups/page-'.$page->id.'-recognition-'.now()->format('Ymd-His-u').'.json';
            if (! Storage::disk('local')->put($backup, json_encode([
                'page_id' => $page->id,
                'attributes' => $original,
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR))) {
                $this->error('Could not create the backup. No changes were saved.');

                return self::FAILURE;
            }
            $page->fill($converted)->save();
            $this->info("Page {$page->id} updated. Backup: {$backup}");

            return self::SUCCESS;
        });
    }
}
