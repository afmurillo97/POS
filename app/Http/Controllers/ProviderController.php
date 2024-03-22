<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Requests\ProviderFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProviderController extends Controller
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

        $providersQuery = Provider::orderBy('id', 'desc');

        if ($query) {
            $providersQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', '%'.$query.'%')
                            ->orWhere('id_type', 'LIKE', '%'.$query.'%')
                            ->orWhere('id_number', 'LIKE', '%'.$query.'%')
                            ->orWhere('address', 'LIKE', '%'.$query.'%')
                            ->orWhere('phone', 'LIKE', '%'.$query.'%')
                            ->orWhere('email', 'LIKE', '%'.$query.'%');
            });
        }

        $providers = $providersQuery->paginate(3);

        return view('shopping.providers.index', ['providers' => $providers, 'searchText' => $query]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('shopping.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProviderFormRequest $request): RedirectResponse
    {

        $provider = new Provider();
        $provider->name = $request->get('name');
        $provider->id_type = $request->get('id_type');
        $provider->id_number = $request->get('id_number');
        $provider->address = $request->get('address');
        $provider->phone = $request->get('phone');
        $provider->email = $request->get('email');
        $provider->status = '1';

        $provider->save();

        return Redirect::to('shopping/providers')->with('success', 'New Provider added successfully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider): View
    {
        return view('shopping.providers.show', ['provider' => $provider]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider): View
    {
        return view('shopping.providers.edit', ['provider' => $provider]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProviderFormRequest $request, Provider $provider): RedirectResponse
    {
        $provider->name = $request->get('name');
        $provider->id_type = $request->get('id_type');
        $provider->address = $request->get('address');
        $provider->phone = $request->get('phone');
        $provider->email = $request->get('email');
        $provider->status = '1';

        $provider->update($request->except('id_number'));

        return Redirect::to('shopping/providers/'. $provider->id .'/edit')->with('success', 'Provider updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider): RedirectResponse
    {
        $provider->delete();

        return Redirect::to('shopping/providers')->with('success', 'Provider '. $provider->name .' deleted successfully!!!');
    }

    /**
     * Enable/Disable the specified resource from storage.
     */
    public function toggle(Request $request, Provider $provider): RedirectResponse
    {
        $provider->status = ($provider->status === '1') ? '0' : '1';
        $message = ($provider->status === '1') ? 'enabled' : 'disabled';
        $provider->save();

        $page = $request->input('page');

        return Redirect::to('shopping/providers?page='. $page)->with('success', 'Provider '. $provider->name .' '.$message.' successfully!!!');
    }
}
