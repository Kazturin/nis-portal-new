<?php

namespace App\Models;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\BannerCardBlock;
use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;

class TextWidget extends Model
{
    use InvalidatesHomepageCache, HasFactory;
    use InteractsWithRichContent;
    protected $fillable = [
        'key',
        'title_kk',
        'title_ru',
        'title_en',
        'content_kk',
        'content_ru',
        'content_en',
        'link_kk',
        'link_ru',
        'link_en',
        'active'
    ];

     public function renderRichContent(string $attribute): string
    {
        $attribute = $this
            ->getRichContentAttribute($attribute) ?? \Filament\Forms\Components\RichEditor\RichContentAttribute::make($this, $attribute);

        return $attribute->getRenderer()->toUnsafeHtml();
    }

    public function setUpRichContent(): void
    {
        $this->registerRichContent('content_kk')
            ->fileAttachmentsDisk('public')
            ->plugins([
                new \App\Filament\Forms\Components\RichEditor\Plugins\TableColorPlugin(),
            ])
            ->customBlocks([
                BannerCardBlock::class,
            ]);

        $this->registerRichContent('content_ru')
            ->fileAttachmentsDisk('public')
            ->plugins([
                new \App\Filament\Forms\Components\RichEditor\Plugins\TableColorPlugin(),
            ])
            ->customBlocks([
                BannerCardBlock::class,
            ]);

        $this->registerRichContent('content_en')
            ->fileAttachmentsDisk('public')
            ->plugins([
                new \App\Filament\Forms\Components\RichEditor\Plugins\TableColorPlugin(),
            ])
            ->customBlocks([
                BannerCardBlock::class,
            ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($textWidget) {
            Cache::forget($textWidget->key);
            self::invalidateHomepageHtml();
        });

        static::updated(function ($textWidget) {
            Cache::forget($textWidget->key);
            self::invalidateHomepageHtml();
        });

        static::deleted(function ($textWidget) {
            Cache::forget($textWidget->key);
            self::invalidateHomepageHtml();
        });
    }
}
