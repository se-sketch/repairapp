<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Subdivision;
use App\Models\Nomenclature;
use App\Models\OrderMaterial;

class OrderMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  // ->except('index')

        $this->middleware('role:mechanic');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', OrderMaterial::class);

        $user = Auth::user();

        if ($user->hasRole('chief')){
            $orders = OrderMaterial::with('user', 'subdivision')
            ->orderByDesc('id')->get();
        }else{
            $orders = OrderMaterial::with('user', 'subdivision')
            ->where('user_id', $user->id)->orderByDesc('id')->get();
        }

        return view('order_material.index', compact('orders'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', OrderMaterial::class);

        $order = new OrderMaterial();

        $subdivisions = Subdivision::select('id', 'name')->get();

        $nomenclatures = Nomenclature::select('id', 'name')->get();

        $subdivision_id = '';

        return view('order_material.create', compact('order', 
            'subdivisions', 'subdivision_id', 'nomenclatures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', OrderMaterial::class);

        $data = $this->validateRequest();
        $data['user_id'] = Auth::id();
        //$data['active'] = true;

        $details = $this->getDetailsQty($data["qtys"]);

        unset($data["qtys"]);
        
        $messge = '';
        $id = OrderMaterial::SaveOrder($data, $details, $messge);

        if (!($id > 0)){
            return redirect()->back()->with('warning', 'Error: '. $messge);
        }

        return redirect()->route('orders.index')
            ->with('success', 'order was created successfully # '.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(OrderMaterial $order)
    {
        $this->authorize('view', $order);

        $order->load('user', 'subdivision', 'details', 
            'details.nomenclature');

        return view('order_material.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderMaterial $order)
    {
       $this->authorize('update', $order);

        $order->load('user', 'subdivision', 'details', 
            'details.nomenclature');

        $subdivisions = Subdivision::select('id', 'name')->get();

        $nomenclatures = Nomenclature::select('id', 'name')->get();

        $subdivision_id = $order->subdivision->id;

        return view('order_material.edit', compact('order', 
            'subdivisions', 'subdivision_id', 'nomenclatures'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderMaterial $order)
    {
        $this->authorize('update', $order);

        $data = $this->validateRequest();
        $data['user_id'] = Auth::id();
        //$data['active'] = true;

        $details = $this->getDetailsQty($data["qtys"]);

        unset($data["qtys"]);
        
        $messge = '';
        $result = OrderMaterial::UpdateOrder($data, $details, $message, 
            $order);

        if (!$result){
            return redirect()->back()->with('warning', 'Error: '. $messge);
        }

        return redirect()->route('orders.index')
            ->with('success', 'order was updated successfully # '.$order->id);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderMaterial $order)
    {
        $this->authorize('delete', $order);

        $id = $order->id;

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'order was deleted successfully # '.$id);       
    }

    private function validateRequest()
    {
        $data = request()->validate([
            "subdivision_id" => "required|integer|min:1",
            "qtys" => "required",
            "qtys.*.qty" => "required",
        ]);
    
        return $data;
    }    

    private function getDetailsQty($qtys){

        if (!is_array($qtys)){
            return [];
        }

        $details = [];
        foreach ($qtys as $key => $value) {
            $details[] = [
                'nomenclature_id' => $key,
                'qty' => $value['qty'],
            ];
        }

        return $details;
    }    
}
