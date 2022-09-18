<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ObjectRepair;
use App\Models\Subdivision;
use App\Models\Nomenclature;
use App\Models\WriteOffOfMaterial;

class WriteOffOfMaterialController extends Controller
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
        $this->authorize('viewAny', WriteOffOfMaterial::class);

        $user = Auth::user();

        if ($user->hasRole('chief')){
            $writeoffs = WriteOffOfMaterial::with('user', 'subdivision', 'object_repair')
            ->orderByDesc('id')->get();
        }else{
            $writeoffs = WriteOffOfMaterial::with('user', 'subdivision', 'object_repair')
            ->where('user_id', $user->id)->orderByDesc('id')->get();
        }

        return view('write_off_of_material.index', compact('writeoffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', WriteOffOfMaterial::class);

        $writeoff = new WriteOffOfMaterial();

        $object_repairs = ObjectRepair::select('id', 'name')->get();

        $subdivisions = Subdivision::select('id', 'name')->get();

        $nomenclatures = Nomenclature::select('id', 'name')->get();

        $object_repair_id = ''; 
        $subdivision_id = '';

        return view('write_off_of_material.create', compact('writeoff', 'object_repairs', 
            'subdivisions', 'object_repair_id', 'subdivision_id', 'nomenclatures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', WriteOffOfMaterial::class);

        $data = $this->validateRequest();
        $data['user_id'] = Auth::id();
        $data['active'] = true;

        $details = $this->getDetailsQty($data["qtys"]);

        unset($data["qtys"]);
        
        $messge = '';
        $id = WriteOffOfMaterial::SaveWriteOff($data, $details, $messge);

        if (!($id > 0)){
            return redirect()->back()->with('warning', 'Error: '. $messge);
        }

        return redirect()->route('writeoffs.index')
            ->with('success', 'writeoff was created successfully # '.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(WriteOffOfMaterial $writeoff)
    {
        $this->authorize('view', $writeoff);

        $writeoff->load('user', 'subdivision', 'object_repair', 'details', 
            'details.nomenclature');

        return view('write_off_of_material.show', compact('writeoff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(WriteOffOfMaterial $writeoff)
    {
        $this->authorize('update', $writeoff);

        $writeoff->load('user', 'subdivision', 'object_repair', 'details', 
            'details.nomenclature');

        $object_repairs = ObjectRepair::select('id', 'name')->get();

        $subdivisions = Subdivision::select('id', 'name')->get();

        $nomenclatures = Nomenclature::select('id', 'name')->get();

        $object_repair_id = $writeoff->object_repair->id; 
        $subdivision_id = $writeoff->subdivision->id;

        return view('write_off_of_material.edit', compact('writeoff', 'object_repairs', 
            'subdivisions', 'object_repair_id', 'subdivision_id', 'nomenclatures'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WriteOffOfMaterial $writeoff)
    {
        $this->authorize('update', $writeoff);

        $data = $this->validateRequest();
        $data['user_id'] = Auth::id();
        $data['active'] = true;

        $details = $this->getDetailsQty($data["qtys"]);

        unset($data["qtys"]);
        
        $messge = '';
        $result = WriteOffOfMaterial::UpdateWriteOff($data, $details, $message, 
            $writeoff);

        if (!$result){
            return redirect()->back()->with('warning', 'Error: '. $messge);
        }

        return redirect()->route('writeoffs.index')
            ->with('success', 'writeoff was updated successfully # '.$writeoff->id);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(WriteOffOfMaterial $writeoff)
    {
        $this->authorize('delete', $writeoff);

        $id = $writeoff->id;

        $writeoff->delete();

        return redirect()->route('writeoffs.index')
            ->with('success', 'writeoff was deleted successfully # '.$id);        
    }

    private function validateRequest()
    {
        $data = request()->validate([
            "object_id" => "required|integer|min:1",
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
