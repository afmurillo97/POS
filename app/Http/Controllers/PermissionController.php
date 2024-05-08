<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        
        $this->middleware(function ($request, $next) {
            
            if (!Gate::allows('Show Permissions')) {
                abort(403);
            }
    
            return $next($request);
        })->only('index');

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = strtolower($request->input('searchText'));

        $permissionsQuery = Permission::orderBy('id', 'desc');

        if ($query) {
            $permissionsQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('id', 'LIKE', '%'.$query.'%')
                            ->orWhere('name', 'LIKE', '%'.$query.'%');
            });
        }

        $permissions = $permissionsQuery->paginate(5);
        
        return view('security.permissions.index', ['permissions' => $permissions, 'searchText' => $query]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionFormRequest $request): RedirectResponse
    {
        
        $permission = Permission::create(['name' => $request->get('name')]);

        return Redirect::to('security/permissions')->with('success', 'New Permission added successfully!!!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionFormRequest $request, Permission $permission): RedirectResponse
    {
        $permission->update(['name' => $request->get('name')]);

        return Redirect::to('security/permissions')->with('success', 'Permission updated successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();

        return Redirect::to('security/permissions')->with('success', 'Permission deleted successfully!!!');
    }
}
