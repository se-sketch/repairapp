<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Auth;
//use PhpParser\Node\Stmt\TryCatch;

use App\Others\Balance;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.home');
    }

    /*
    public function show($id)
    {
        dd('show');

        return view('home.show', compact('nomenclature', 'images'));
    }    

    public function store(Request $request)
    {
        dd('store');
    } 
    */

    public function showbalance(){
        
        $this->middleware('auth');
        $this->middleware('role:mechanic');

        $balance = new Balance;
        $table = $balance->getBalance(null, null, null, true);

        return view('home.showbalance', compact('table'));
    }

}
