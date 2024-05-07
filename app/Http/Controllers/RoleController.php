<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
       
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = strtolower($request->input('searchText'));

        $roles = Role::orderBy('id', 'desc')->paginate(5);
        $permissions = Permission::all();

        return view('security.roles.index', [
            'roles' => $roles, 
            'permissions' => $permissions, 
            'searchText' => $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permission = Permission::get();
        return view('security.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $role = Role::create(['name' => $request->get('name')]);

        return Redirect::to('security/roles')->with('success', 'New Role added successfully!!!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        return view('security.roles.show', ['role' => $role]);        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        return view('security.roles.edit', ['role' => $role]);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {

        $role->permissions()->sync($request->permissions);
        return Redirect::to('security/roles')->with('success', 'Role updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return Redirect::to('security/roles')->with('success', 'Role deleted successfully!!!');
    }

}
