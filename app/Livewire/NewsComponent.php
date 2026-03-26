<?php

namespace App\Livewire;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class NewsComponent extends Component
{
   // public $news;
    public $news;

    public function mount(){
        $this->news = News::query()->where('active',true)->where('published_at','<',now())->latest('published_at')->limit(5)->get();

      //  dd($this->news);
    }

    public function render()
    {
        return view('livewire.news-component');
    }
}
