<?php

namespace App\Models;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\AnimatedNumbersBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\BookAccordionBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ColoredBackgroundBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ContactBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\CurriculumCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\CurriculumResultBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\EducationLevelsBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\FixedButtonBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\FullSliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\GallerySliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\HorizontalCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\OrnamentCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\TextSliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\VerticalCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\WorldMapBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock;
use App\Models\Alumni\AlumniNews;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property \App\Models\Menu|null $menu
 * @property \App\Models\Page|null $parent
 * @property int|null $parent_id
 * @property int $id
 */
class Page extends Model
{
    use HasSlug;
    use InteractsWithRichContent;
    protected $fillable = [
        'title_kk',
        'title_ru',
        'title_en',
        'slug',
        'content_kk',
        'content_ru',
        'content_en',
        'menu_id',
        'parent_id',
        'active',
        'lists_view_type',
        'is_protected'
    ];

    protected $casts = [
        'lists_view_type' => \App\Enums\ListViewType::class,
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

    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class, "menu_id", "id");
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PageFile::class, 'page_id')->orderBy('created_at', 'desc');
    }

    public function pageList(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PageList::class, 'page_id')->orderBy('position');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Page::class, 'id', 'parent_id');
    }

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function edited(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }


    public function getTopParentMenu()
    {
        $menu = $this->menu;

        while ($menu && $menu->parent_id) {
            $menu = Menu::query()->select('id', 'parent_id')->where('id', $menu->parent_id)->first();
        }

        return $menu->id;
    }

    public function getUrlAttribute()
    {
        return route('page', ['locale' => app()->getLocale(), 'page' => $this->slug]);
    }

    public function banner(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PageBanner::class, 'page_id', 'id');
    }

    public function tabs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PageTab::class, 'page_id', 'id');
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
                WorldMapBlock::class,
                AnimatedNumbersBlock::class,
                ContactBlock::class,
                YoutubeBlock::class,
                FullSliderBlock::class,
                GallerySliderBlock::class,
                HorizontalCardBlock::class,
                VerticalCardBlock::class,
                OrnamentCardBlock::class,
                TextSliderBlock::class,
                EducationLevelsBlock::class,
                CurriculumCardBlock::class,
                CurriculumResultBlock::class,
                ColoredBackgroundBlock::class,
                FixedButtonBlock::class,
                BookAccordionBlock::class,
            ]);

        $this->registerRichContent('content_ru')
            ->fileAttachmentsDisk('public')
            ->customBlocks([
                WorldMapBlock::class,
                AnimatedNumbersBlock::class,
                ContactBlock::class,
                YoutubeBlock::class,
                FullSliderBlock::class,
                GallerySliderBlock::class,
                HorizontalCardBlock::class,
                VerticalCardBlock::class,
                OrnamentCardBlock::class,
                TextSliderBlock::class,
                EducationLevelsBlock::class,
                CurriculumCardBlock::class,
                CurriculumResultBlock::class,
                ColoredBackgroundBlock::class,
                FixedButtonBlock::class,
                BookAccordionBlock::class,
            ]);

        $this->registerRichContent('content_en')
            ->fileAttachmentsDisk('public')
            ->customBlocks([
                WorldMapBlock::class,
                AnimatedNumbersBlock::class,
                ContactBlock::class,
                YoutubeBlock::class,
                FullSliderBlock::class,
                GallerySliderBlock::class,
                HorizontalCardBlock::class,
                VerticalCardBlock::class,
                OrnamentCardBlock::class,
                TextSliderBlock::class,
                EducationLevelsBlock::class,
                CurriculumCardBlock::class,
                CurriculumResultBlock::class,
                ColoredBackgroundBlock::class,
                FixedButtonBlock::class,
                BookAccordionBlock::class,
            ]);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });
        // static::updating(function ($model) {
        //     $model->updated_by = Auth::id();
        // });

        static::created(function () {
            Cache::forget('menu');
        });

        static::updated(function () {
            Cache::forget('menu');
        });
        static::deleted(function () {
            Cache::forget('menu');
        });
    }
}