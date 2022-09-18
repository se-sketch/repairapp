<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\ReceiptOfMaterial;
use App\Models\ReceiptDetail;
use App\Models\Subdivision;
use App\Models\Nomenclature;

use App\Others\Balance;

class ReceiptOfMaterialController extends Controller
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
        $this->authorize('viewAny', ReceiptOfMaterial::class);
        

        $user = Auth::user();

        if ($user->hasRole('chief')){
            $receipts = ReceiptOfMaterial::with('user', 'subdivision')
            ->orderByDesc('id')->get();
        }else{
            $receipts = ReceiptOfMaterial::with('user', 'subdivision')
            ->where('user_id', $user->id)->orderByDesc('id')->get();
        }

        return view('recept_material.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ReceiptOfMaterial::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', ReceiptOfMaterial::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceiptOfMaterial  $receiptOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiptOfMaterial $receipt)
    {
        $this->authorize('view', $receipt);

        $receipt->load('user', 'subdivision', 'details', 
            'details.nomenclature');

        return view('recept_material.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceiptOfMaterial  $receiptOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiptOfMaterial $receipt)
    {
        $this->authorize('update', ReceiptOfMaterial::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReceiptOfMaterial  $receiptOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceiptOfMaterial $receipt)
    {
        $this->authorize('update', ReceiptOfMaterial::class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceiptOfMaterial  $receiptOfMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiptOfMaterial $receipt)
    {
        $this->authorize('delete', ReceiptOfMaterial::class);
    }
}
