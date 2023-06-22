<?php

namespace App\Http\Livewire\Logistic\Requirement;

use App\Models\Supplier;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $supplierRuc = '';
    public $supplierName = '';
    public $supplierAddress = '';
    public $paymentMethod = '1';
    public $products = [
        [
            'id' => '',
            'quantity' => '',
            'price' => ''
        ]
    ];

    protected $listeners = ['openModal','getProducts'];

    public function rules(){
        return [
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|numeric',
            'products.*.price' => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'products.*.id' => 'El producto es requerido',
            'products.*.quantity' => 'La cantidad es requerida',
            'products.*.price' => 'El precio es requerido',
        ];
    }

    public function openModal(){
        $this->reset('products');
        $this->open = true;
    }

    public function getProducts($products){
        $this->products = $products;
        $this->open = true;
    }

    public function addProduct(){
        $this->products[] = [
            'id' => '',
            'quantity' => '',
            'price' => '',
        ];
    }

    public function removeProduct($index){
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    //Buscar Proveedor
    public function updatedSupplierRuc (){
        if(strlen($this->supplierRuc) != 11){
            $this->alert('warning', 'Ruc o Dni incorrecto', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
            $this->reset('supplierName','supplierAddress');
            return false;
        }
        if(Supplier::where('ruc',$this->supplierRuc)->exists()){
            $empresa = Supplier::where('ruc',$this->supplierRuc)->first();
            $this->supplierName = $empresa->name;
            $this->supplierAddress = $empresa->address;
            $this->alert('success', 'Proveedor Encontrado', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $empresa = $this->getEntityApi($this->supplierRuc);
            if(isset($empresa->numeroDocumento)){
                $this->supplierName = $empresa->nombre;
                $this->supplierAddress = $empresa->direccion;
                $this->alert('success', 'Proveedor Encontrado', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }else{
                $this->reset('supplierName','supplierAddress');
                $this->alert('error', 'El Cliente no existe', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }
        }
    }

    public function getEntityApi($numero){
        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar ruc sunat
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $numero,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Referer: http://apis.net.pe/api-ruc',
            'Authorization: Bearer ' . env('API_SUNAT')
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $empresa = json_decode($response);
        if(isset($empresa->numeroDocumento)){
            Supplier::updateOrCreate([
                'ruc' => $empresa->numeroDocumento,
                'name' => strtoupper($empresa->nombre),
                'address' => strtoupper($empresa->direccion)
            ]);
        }

        // Datos de empresas según padron reducido
        return $empresa;
    }

    public function render()
    {
        return view('livewire.logistic.requirement.modal');
    }
}
