<?php

namespace App\Http\Livewire\Logistic\Product;

use App\Exceptions\ImportErrorException;
use App\Exports\FormatExport;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $openImport;
    public $archivo;
    public $fileNumber;

    public function rules(){
        return [
            'archivo' => 'required|file'
        ];
    }

    public function mount(){
        $this->openImport = false;
    }

    public function openModal(){
        $this->emitTo('logistic.product.modal','openModal',0);
    }

    public function openImportModal(){
        $this->fileNumber++;
        $this->archivo = null;
        $this->openImport = true;
    }

    public function import(){
        $this->validate();
        try {
            Excel::import(new ProductImport,$this->archivo);
            $this->emit('refreshDatatable');
            $this->alert('success','¡Productos importados!',[
                'position' => 'center',
                'timer' => 2000,
                'toast' => false
            ]);
            $this->openImport = false;
        }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $errores = $e->failures();
            $this->alert('error', $errores[0]->errors(), [
                'position' => 'center',
                'timer' => 10000,
                'toast' => false,
            ]);
        }catch (ImportErrorException $e) {
            $this->alert('error', $e->getMessage(), [
                'position' => 'center',
                'timer' => 10000,
                'toast' => false,
            ]);
        } catch (\Exception $e) {
            $this->alert('error',$e, [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    public function exportFormat(){
        $columns = ['Producto','Descripcion','Categoria','Unidad de Medida','Abreviacion'];
        $export = new FormatExport($columns);
        return Response::streamDownload(function () use ($export) {
            Excel::store($export, 'temp.xlsx');
            readfile(storage_path('app/temp.xlsx'));
        }, 'Formato de Productos.xlsx');

    }

    public function render()
    {
        return view('livewire.logistic.product.base');
    }
}
