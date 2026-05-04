<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\DB;

trait SeedsMandatoryWidgets
{
    protected function seedMandatoryWidgets()
    {
        $mandatoryWidgets = [
            'call_center', 'trademark', 'helpline', 'top_button', 
            'mission', 'opportunities_block', 'resources_block'
        ];
        foreach ($mandatoryWidgets as $key) {
            DB::table('text_widgets')->updateOrInsert(
                ['key' => $key],
                [
                    'title_kk' => "Title KK $key",
                    'title_ru' => "Title RU $key",
                    'title_en' => "Title EN $key",
                    'content_kk' => "Content KK $key",
                    'content_ru' => "Content RU $key",
                    'content_en' => "Content EN $key",
                    'active' => true,
                ]
            );
        }
    }
}
