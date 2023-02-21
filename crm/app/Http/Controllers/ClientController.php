<?php

namespace App\Http\Controllers;

use App\Services\ClientApi;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Http\Requests\ClientRequest;
use Illuminate\Routing\Redirector;

class ClientController extends Controller
{
    const CLIENT = 'client';

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function index()
    {
        $clients = (new ClientApi(Auth::user(), self::CLIENT))->getClients();
        return view('dashboard', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientRequest $request
     * @return Application|RedirectResponse|Redirector
     * @throws GuzzleException
     */
    public function store(ClientRequest $request)
    {
        $validated = $request->validated();
        (new ClientApi(Auth::user(), self::CLIENT))->createClient($validated);
        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function show(int $id)
    {
        $client = (new ClientApi(Auth::user(), self::CLIENT))->getClient($id);
        $pets = (new ClientApi(Auth::user(), self::CLIENT))->getPetsByClientId($id);
        return view('clients.show', ['client' => $client, 'pets' => $pets]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function edit(int $id)
    {
        $infoClient = (new ClientApi(Auth::user(), self::CLIENT))->getClient($id);
        return view('clients.edit', ['infoClient' => $infoClient]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientRequest $request
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     * @throws GuzzleException
     */
    public function update(ClientRequest $request, int $id)
    {
        $validated = $request->validated();
        (new ClientApi(Auth::user(), self::CLIENT))->editClient($validated, $id);
        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     * @throws GuzzleException
     */
    public function destroy(int $id)
    {
        (new ClientApi(Auth::user(), self::CLIENT))->deleteClient($id);
        return redirect('/dashboard');
    }

    /**
     * @throws GuzzleException
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $searchClient = (new ClientApi(Auth::user(), self::CLIENT))->searchClient($query);
        return view('clients.search', ['searchClient' => $searchClient]);
    }
}
