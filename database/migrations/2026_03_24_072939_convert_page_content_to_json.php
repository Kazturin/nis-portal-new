<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $pages = \App\Models\Page::all();

        // Создаем временную страницу, чтобы получить настроенный редактор
        $tempPage = new \App\Models\Page();
        // Это подтянет все расширения (Image, WorldMap, Youtube и т.д.)
        $renderer = $tempPage->getRichContentAttribute('content_kk')->getRenderer();
        $editor = $renderer->getEditor();

        foreach ($pages as $page) {
            $changed = false;
            foreach (['content_kk', 'content_ru', 'content_en'] as $field) {
                // Получаем оригинал HTML из базы (до того как отработал cast 'array')
                $raw = $page->getRawOriginal($field);

                if ($raw && !str_starts_with(trim($raw), '{') && !str_starts_with(trim($raw), '[')) {
                    try {
                        // Теперь $editor знает про расширения и сохранит <img> в JSON
                        $json = $editor->setContent($raw)->getDocument();

                        // Если в JSON есть картинки, они теперь будут с атрибутом 'id'
                        $page->{$field} = $json;
                        $changed = true;
                    } catch (\Exception $e) {
                        // Пропускаем в случае ошибки
                        \Log::error("Failed to convert page {$page->id}: " . $e->getMessage());
                    }
                }
            }
            if ($changed) {
                $page->save();
            }
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversing JSON to HTML is possible but usually we don't want to lose data structure.
        // If needed, we could use ->setContent($json)->getHTML()
    }
};
