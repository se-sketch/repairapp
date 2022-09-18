<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Role;
use App\Models\Employee;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  // ->except('index')

        //$this->middleware('role:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::select('id', 'name', 'email', 'created_at')
        ->with('roles')->orderByDesc('id')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = Role::all();

        $employees = Employee::all();

        return view('users.edit', compact('user', 'roles', 'employees'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $this->validateRequest();

        $roles = [];
        if (array_key_exists('roles', $data)){
            $roles = $data['roles'];
        }

        unset($data['roles']);

        DB::beginTransaction();
        try{
            
            $user->update($data);

            $user->roles()->sync($roles);

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            return back()->with('warning', 'Элемент НЕ записан! '.$e->getMessage());
        }

        return redirect()->route('users.index')->with('success', 'Элемент записан!');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
    }

    public function validateRequest()
    {
        $data = request()->validate([
            'employee_id' => 'nullable|string|min:10|max:10',
            'roles' => 'nullable|array',
        ]);

        return $data;
    }
}
