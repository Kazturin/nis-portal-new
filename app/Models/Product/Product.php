<?php

namespace App\Models\Product;

use App\Contracts\Routable;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\BorderedTextBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\CheckListBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ColoredBackgroundBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\FullSliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\GallerySliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\HorizontalCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ImageBottomTextBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ImageWithOverlayBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\KeyBenefitsBlock;
use App\Models\Menu;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements Routable
{
    use HasSlug;
    use InteractsWithRichContent;

    protected $fillable = [
        'title_kk',
        'title_ru',
        'title_en',
        'content_kk',
        'content_ru',
        'content_en',
        'image',
        'slug',
        'active',
        'menu_id'
    ];

    protected $casts = [
        'content_kk' => 'array',
        'content_ru' => 'array',
        'content_en' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title_kk')
            ->saveSlugsTo('slug');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ProductComment::class);
    }

    public function formSchema(): HasOne
    {
        return $this->hasOne(ProductFormSchema::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(ProductRequest::class);
    }

    public function menu()
    {
        return $this->morphOne(Menu::class, 'menuable');
    }

    public function getMenuUrl(string $locale): string
    {
        return route('product', ['locale' => $locale, 'product' => $this->slug]);
    }

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
            ->customBlocks([
                KeyBenefitsBlock::class,
                ImageBottomTextBlock::class,
                FullSliderBlock::class,
                HorizontalCardBlock::class,
                GallerySliderBlock::class,
                ImageWithOverlayBlock::class,
                BorderedTextBlock::class,
                ColoredBackgroundBlock::class,
                CheckListBlock::class,
            ]);

        $this->registerRichContent('content_ru')
            ->fileAttachmentsDisk('public')
            ->customBlocks([
                KeyBenefitsBlock::class,
                ImageBottomTextBlock::class,
                FullSliderBlock::class,
                HorizontalCardBlock::class,
                GallerySliderBlock::class,
                ImageWithOverlayBlock::class,
                BorderedTextBlock::class,
                ColoredBackgroundBlock::class,
                CheckListBlock::class,
            ]);

        $this->registerRichContent('content_en')
            ->fileAttachmentsDisk('public')
            ->customBlocks([
                KeyBenefitsBlock::class,
                ImageBottomTextBlock::class,
                FullSliderBlock::class,
                HorizontalCardBlock::class,
                GallerySliderBlock::class,
                ImageWithOverlayBlock::class,
                BorderedTextBlock::class,
                ColoredBackgroundBlock::class,
                CheckListBlock::class,
            ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget('products');
        });

        static::updated(function () {
            Cache::forget('products');
        });

        static::deleted(function () {
            Cache::forget('products');
        });
    }
}
