<?php

namespace App\Http\Controllers;

use App\Services\VetmanagerApi;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function index()
    {
        $clients = (new VetmanagerApi(auth()->user()))->getClients();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'home_phone' => ['required'],
            'email' => ['required'],
        ]);
        (new VetmanagerApi(auth()->user()))->createClient($validated);
        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function show(int $id)
    {
        $client = (new VetmanagerApi(auth()->user()))->getClient($id);
        return view('clients.show', ['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('clients.edit', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'home_phone' => ['required'],
            'email' => ['required']
        ]);
        (new VetmanagerApi(auth()->user()))->editClient($validated, $id);
        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function destroy(int $id)
    {
        (new VetmanagerApi(auth()->user()))->deleteClient($id);
        return redirect('/dashboard');
    }

    // Поисковик

    /**
     * @throws GuzzleException
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $searchClient = (new VetmanagerApi(auth()->user()))->searchClient($query);
        return view('clients.search', ['searchClient' => $searchClient]);
    }
}
