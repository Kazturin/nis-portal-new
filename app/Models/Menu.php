<?php

namespace App\Models;

use App\Models\Page;
use App\Models\Product\Product;
use App\Traits\InvalidatesHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property \App\Models\Menu|null $parent
 * @property int|null $parent_id
 * @property string|null $slug
 * @property string|null $title_ru
 * @property string|null $title_kk
 * @property string|null $title_en
 * @property \App\Models\Product\Product|null $product
 */


class Menu extends Model
{
    use HasSlug, InvalidatesHomepageCache, HasFactory;

    const POSITION_HEADER = 0;
    const POSITION_FOOTER = 1;

    public $timestamps = false;
    protected $fillable = [
        'title_kk',
        'title_ru',
        'title_en',
        'slug',
        'link_kk',
        'link_ru',
        'link_en',
        'is_external_link',
        'parent_id',
        'sort',
        'active',
        'banner',
        'open_in_new_tab',
        'position',
    ];

    protected $casts = [
        'active' => 'boolean',
        'is_external_link' => 'boolean',
        'open_in_new_tab' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title_kk')
            ->saveSlugsTo('slug');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function page(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Page::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function getBanner()
    {
        if ($this->banner) {
            return '/storage/' . $this->banner;
        }
        return '/img/page_banner.png';
    }

    public function getUrl()
    {
        $locale = app()->getLocale();
        if ($this->product) {
            return route('product', ['locale' => $locale, 'product' => $this->product->slug]);
        }
        if ($this->is_external_link) {
            return $this->{'link_' . $locale};
        } elseif ($this->link_kk && \Illuminate\Support\Facades\Route::has($this->link_kk)) {
            return route($this->link_kk, ['locale' => $locale]);
        } else {
            return $this->page ? route('page', ['locale' => $locale, 'page' => $this->page->slug]) : '#';
        }
    }

    protected static function boot()
    {
        parent::boot();


        $clearCache = function () {
            if (Cache::supportsTags()) {
                Cache::tags(['menus', 'pages'])->flush();
            } else {
                foreach (['kk', 'ru', 'en'] as $locale) {
                    Cache::forget("menu_tree_" . self::POSITION_HEADER . "_{$locale}");
                    Cache::forget("menu_tree_" . self::POSITION_FOOTER . "_{$locale}");
                    Cache::forget("menu_tree_serialized_" . self::POSITION_HEADER . "_{$locale}");
                    Cache::forget("menu_tree_serialized_" . self::POSITION_FOOTER . "_{$locale}");
                }
            }
            self::invalidateHomepageHtml();
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }

    protected static function invalidateHomepageHtml()
    {
        Cache::forget('homepage_html_kk');
        Cache::forget('homepage_html_ru');
        Cache::forget('homepage_html_en');
    }

}
