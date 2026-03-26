<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \App\Models\Page|null $page
 */
class PageFile extends Model
{
    protected $fillable = [ 
        'title_kk',
        'title_ru',
        'title_en',
        'file_kk',
        'file_ru',
        'file_en',
        'page_id',
        'files_kk',
        'files_ru',
        'files_en',
        'thumbnail',
        'position',
        'link_kk',
        'link_ru',
        'link_en',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    protected $casts = [
        'files_kk' => 'array',
        'files_ru' => 'array',
        'files_en' => 'array',
    ];

    public function getFile(){
        return '/storage/'.$this->{'file_'.app()->getLocale()};
    }

    public function getFiles(){
        $files = [];
  
        foreach($this->{'files_'.app()->getLocale()} as $file){
           $files[] = (string)'/storage/'.$file;
        }
 
        return $files;
    }

    public function getThumbnail(){
        if($this->thumbnail){
           return '/storage/'. $this->thumbnail;
        }
        return '/img/docs.jpg';
    }


}
