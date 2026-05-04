<?php

namespace Tests\Unit\Providers;

use Tests\TestCase;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Facades\Storage;

class AppServiceProviderTest extends TestCase
{
    public function test_rich_editor_configuration_strips_domain_from_url()
    {
        $editor = RichEditor::make('content')->fileAttachmentsDisk('public');

        Storage::shouldReceive('disk')
            ->with('public')
            ->andReturnSelf();
            
        Storage::shouldReceive('url')
            ->with('test-image.jpg')
            ->andReturn('https://nis-portal.test/storage/test-image.jpg');

        $url = $editor->getFileAttachmentUrl('test-image.jpg');

        $this->assertEquals('/storage/test-image.jpg', $url);
        
        // Also test with http
        Storage::shouldReceive('url')
            ->with('test-image-http.jpg')
            ->andReturn('http://nis-portal.test/storage/test-image-http.jpg');
            
        $urlHttp = $editor->getFileAttachmentUrl('test-image-http.jpg');
        $this->assertEquals('/storage/test-image-http.jpg', $urlHttp);
    }
}
