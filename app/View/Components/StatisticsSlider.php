<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class StatisticsSlider extends Component
{
    public array $slides = [];

    public function __construct(Collection $statistics)
    {
        $statistics = $statistics->values();
        $layouts = ['featured' => 4, 'photo-right' => 2, 'grid' => 3, 'photo-left' => 2];
        $offset = 0;

        while ($offset < $statistics->count()) {
            foreach ($layouts as $layout => $size) {
                $items = $statistics->slice($offset, $size)->values();

                if ($items->isEmpty()) {
                    break;
                }

                $this->slides[] = ['layout' => $layout, 'statistics' => $items];
                $offset += $size;
            }
        }
    }

    public function render(): View
    {
        return view('components.statistics-slider');
    }
}
