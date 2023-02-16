<?php

namespace App\Http\Controllers;

use App\Services\VetmanagerApi;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create($ownerId)
    {
        return view('pets.create', ['ownerId' => $ownerId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => ['required'],
            'alias' => ['required'],
            'type_id' => ['required'],
            'breed_id' => ['required'],
        ]);
        (new VetmanagerApi(auth()->user()))->createClient(VetmanagerApi::PET, $validated);
        return redirect("/clients/{$validated['owner_id']}");
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
        $pet = (new VetmanagerApi(auth()->user()))->getClient(VetmanagerApi::PET, $id);
        return view('pets.show', ['pet' => $pet]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('pets.edit', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'alias' => ['required'],
            'type_id' => ['required'],
            'breed_id' => ['required'],
        ]);
        (new VetmanagerApi(auth()->user()))->editClient(VetmanagerApi::PET, $validated, $id);
        return redirect("pet/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        (new VetmanagerApi(auth()->user()))->deleteClient(VetmanagerApi::PET, $id);
        return redirect('dashboard');
    }
}
