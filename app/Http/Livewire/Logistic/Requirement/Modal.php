<?php

namespace App\Http\Livewire\Logistic\Requirement;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $supplierRuc = '';
    public $supplierName = '';
    public $supplierAddress = '';
    public $paymentMethod = '0';
    public $requeriments = [];
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
            'supplierRuc' => 'required|size:11|exists:suppliers,ruc|regex:/^[0-9]+$/',
            'supplierName' => 'required',
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|numeric',
            'products.*.price' => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'supplierRuc.required' => 'El ruc es obligatorio',
            'supplierName.required' => 'El proveedor es obligatorio',
            'supplierRuc.size' => 'El ruc debe tener 11 digitos',
            'supplierRuc.exists' => 'El proveedor no existe',
            'supplierRuc.regex' => 'El ruc debe tener numeros solamente',
            'products.*.id' => 'El producto es requerido',
            'products.*.quantity' => 'La cantidad es requerida',
            'products.*.price' => 'El precio es requerido',
        ];
    }

    public function openModal(){
        $this->reset('products');
        $this->open = true;
    }

    public function getProducts($products,$requeriments){
        $this->requeriments = $requeriments;
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

    public function save(){
        $this->validate();
        DB::transaction(function () {
            $purcharseOrder = PurchaseOrder::create([
                'supplier_id' => Supplier::where('ruc',$this->supplierRuc)->first()->id,
                'credit' => $this->paymentMethod,
                'amount' => array_reduce($this->products, fn ($total,$product) =>  $total + $product['price'],0)
            ]);
            foreach($this->products as $product){
                PurchaseOrderDetail::create([
                    'purchase_order_id' => $purcharseOrder->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }
            DB::table('requirements')
                ->whereIn('id', $this->requeriments)
                ->update(['met'=>true]);
            $this->resetExcept();
            $this->emit('clearSelected');
            $this->alert('success', 'Guardado con éxito');
        });
    }

    //Buscar Proveedor
    public function updatedSupplierRuc (){
        if(strlen($this->supplierRuc) == 11 && is_numeric($this->supplierRuc)){
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
        }else{
            $this->alert('warning', 'Ruc o Dni incorrecto', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
            $this->reset('supplierName','supplierAddress');
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

    public function updatedOpen(){
        if(!$this->open){
            $this->resetExcept('open');
        }
    }

    public function render()
    {
        return view('livewire.logistic.requirement.modal');
    }
}
