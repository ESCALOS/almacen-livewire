<?php

namespace App\Http\Livewire\Requester\Requirement;

use Livewire\Component;

class Base extends Component
{
    public function openModal(){
        $this->emitTo('requester.requirement.modal','openModal');
    }
    public function render()
    {
        return view('livewire.requester.requirement.base');
    }
}
