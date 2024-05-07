<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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

        $usersQuery = User::orderBy('id', 'desc');

        // Aplica la búsqueda si se proporciona un término de búsqueda
        if ($query) {
            $usersQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('role', 'LIKE', '%'.$query.'%')
                            ->orWhere('name', 'LIKE', '%'.$query.'%')
                            ->orWhere('email', 'LIKE', '%'.$query.'%');
            });
        }

        $users = $usersQuery->paginate(5);
        $roles = Role::all();

        return view('security.users.index', [
            'users' => $users, 
            'roles' => $roles, 
            'searchText' => $query
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('security.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request): RedirectResponse
    {

        $user = new User();
        $user->role = $request->get('role');
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->status = "1";
        $user->save();

        return Redirect::to('security/users')->with('success', 'New User added successfully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('security.users.show', ['user' => $user]);        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('security.users.edit', ['user' => $user]);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        // $user->role = $request->get('role');
        // $user->name = $request->get('name');
        // $user->email = $request->get('email');
        // $user->password = Hash::make($request->get('password'));
        // $user->status = "1";
        // $user->update();

        // return Redirect::to('security/users/'. $user->id .'/edit')->with('success', 'User updated successfully!');

        $user->roles()->sync($request->roles);
        return Redirect::to('security/users')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::to('security/users')->with('success', 'User deleted successfully!!!');
    }

    /**
     * Enable/Disable the specified resource from storage.
     */
    public function toggle(Request $request, User $user): RedirectResponse
    {
        $user->status = ($user->status == '1') ? '0' : '1';
        $message = ($user->status == '1') ? 'enabled' : 'disabled';
        $user->save();

        $page = $request->input('page');

        return Redirect::to('security/users?page='. $page)->with('success', 'User '. $user->name .' '.$message.' successfully!!!');
    }
}
