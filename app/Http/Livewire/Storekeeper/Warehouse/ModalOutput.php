<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Exceptions\ImportErrorException;
use App\Exports\FormatExport;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ModalOutput extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $openImport;
    public $archivo;
    public $fileNumber;
    
    public function render()
    {
        return view('livewire.storekeeper.warehouse.modal-output');
    }
}
