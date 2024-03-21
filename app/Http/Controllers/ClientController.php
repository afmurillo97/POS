<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ClientController extends Controller
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

        $clientsQuery = Client::orderBy('id', 'desc');

        // Aplica la búsqueda si se proporciona un término de búsqueda
        if ($query) {
            $clientsQuery->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', '%'.$query.'%')
                            ->orWhere('client_type', 'LIKE', '%'.$query.'%')
                            ->orWhere('id_type', 'LIKE', '%'.$query.'%')
                            ->orWhere('id_number', 'LIKE', '%'.$query.'%')
                            ->orWhere('address', 'LIKE', '%'.$query.'%')
                            ->orWhere('phone', 'LIKE', '%'.$query.'%')
                            ->orWhere('email', 'LIKE', '%'.$query.'%');
            });
        }

        $clients = $clientsQuery->paginate(3);

        return view('sales.clients.index', ['clients' => $clients, 'searchText' => $query]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('sales.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientFormRequest $request): RedirectResponse
    {

        $client = new Client();
        $client->name = $request->get('name');
        $client->client_type = $request->get('client_type');
        $client->id_type = $request->get('id_type');
        $client->id_number = $request->get('id_number');
        $client->address = $request->get('address');
        $client->phone = $request->get('phone');
        $client->email = $request->get('email');
        $client->status = '1';

        $client->save();

        return Redirect::to('sales/clients')->with('success', 'New Client added successfully!!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): View
    {
        return view('sales.clients.show', ['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client): View
    {
        return view('sales.clients.edit', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientFormRequest $request, Client $client): RedirectResponse
    {
        $client->name = $request->get('name');
        $client->client_type = $request->get('client_type');
        $client->id_type = $request->get('id_type');
        $client->address = $request->get('address');
        $client->phone = $request->get('phone');
        $client->email = $request->get('email');
        $client->status = '1';

        $client->update($request->except('id_number'));

        return Redirect::to('sales/clients/'. $client->id .'/edit')->with('success', 'Client updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return Redirect::to('sales/clients')->with('success', 'Client '. $client->name .' deleted successfully!!!');
    }

    /**
     * Enable/Disable the specified resource from storage.
     */
    public function toggle(Request $request, Client $client): RedirectResponse
    {
        $client->status = ($client->status === '1') ? '0' : '1';
        $message = ($client->status === '1') ? 'enabled' : 'disabled';
        $client->save();

        $page = $request->input('page');

        return Redirect::to('sales/clients?page='. $page)->with('success', 'Client '. $client->name .' '.$message.' successfully!!!');
    }
}
