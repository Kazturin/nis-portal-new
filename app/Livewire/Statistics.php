<?php

namespace App\Livewire;

use Illuminate\Database\Console\DbCommand;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Statistics extends Component
{
    public $statistics;
    public $current;

    public function mount()
    {
        $this->statistics = DB::table('statistics')->get()->toArray();
        if($this->statistics)
        {
            $this->current = $this->statistics[0];
        }
    }
    public function render()
    {
        //dD($this->statistics);
        return view('livewire.statistics');
    }

    public function selectItem($index)
    {
        $this->current = $this->statistics[$index];
    }
}
