<?php

namespace App\Livewire;

use Livewire\Component;

class ProductRequestsModal extends Component
{
    public $productId;
    public $requests;

    public function mount($productId = null, $requests = null)
    {
        $this->productId = $productId;
        $this->requests = $requests ?? collect();
    }

    public function render()
    {
        return view('livewire.product-requests-modal');
    }
}
