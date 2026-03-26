<?php

namespace App\Models;

use App\Models\Page;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
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
    use HasSlug;

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

    public function parent(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Menu::class, 'id', 'parent_id');
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
        if ($this->product) {
            return route('product', ['locale' => app()->getLocale(), 'product' => $this->product->slug]);
        }
        if ($this->is_external_link) {
            return $this->{'link_' . app()->getLocale()};
        } elseif ($this->link_kk && Route::has($this->link_kk)) {
            return route($this->link_kk, ['locale' => app()->getLocale()]);
        } else {
            return route('page', ['locale' => app()->getLocale(), 'page' => $this->page]);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if ($model->position === self::POSITION_FOOTER) {
                Cache::forget('footer_menu');
            }
            Cache::forget('menu');
        });

        static::updated(function ($model) {

            if ($model->position === self::POSITION_FOOTER) {
                Cache::forget('footer_menu');
            }
            Cache::forget('menu');
        });

        static::deleted(function ($model) {
            if ($model->position === self::POSITION_FOOTER) {
                Cache::forget('footer_menu');
            }
            Cache::forget('menu');
        });
    }

}
