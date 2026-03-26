<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


/**
 * @property \App\Models\Page|null $page
 */
class PageList extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title_kk',
        'title_ru',
        'title_en',
        'description_kk',
        'description_ru',
        'description_en',
        'content_kk',
        'content_ru',
        'content_en',
        'page_id',
        'date',
        'position',
        'image',
        'active'
    ];


    protected $casts = [
        'date' => 'datetime'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getFormattedDate()
    {
        return $this->date ? $this->date->format('d.m.Y') : '';
    }

    public function getImage()
    {
        if (!$this->image) {
            return null;
        }

        // Если уже полный URL
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        // Иначе считаем, что это локальный путь
        return '/storage/' . $this->image;
    }

    public function shortTitle($limit = 100): string
    {
        if($this->{'title_'.app()->getLocale()})
        {
             return Str::limit($this->{'title_'.app()->getLocale()},$limit);
        }
        return '';
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ?: now();
    }

    public function getUrl()
    {
        return route('list.item', ['locale' => app()->getLocale(), 'pageList' => $this->id]);
    }

    // protected static function booted(): void
    // {
    //     static::addGlobalScope('position', function (Builder $builder) {
    //         $builder->orderBy('position');
    //     });
    // }
}
