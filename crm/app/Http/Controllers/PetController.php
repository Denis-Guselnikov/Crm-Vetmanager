<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Services\VetmanagerApi;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    const PET = 'pet';
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
     * @throws GuzzleException
     */
    public function store(PetRequest $request)
    {
        $validated = $request->validated();
        (new VetmanagerApi(auth()->user()))->create(VetmanagerApi::PET, $validated);
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
        $pet = (new VetmanagerApi(Auth::user()))->getOne(VetmanagerApi::PET, $id);
        return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function edit(int $id)
    {
        $infoPet = (new VetmanagerApi(auth()->user()))->getOne(VetmanagerApi::PET, $id);
        return view('pets.edit', compact('id', 'infoPet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws GuzzleException
     */
    public function update(PetRequest $request, int $id)
    {
        $validated = $request->validated();
        (new VetmanagerApi(auth()->user()))->edit(VetmanagerApi::PET, $validated, $id);
        return redirect("pet/$id");
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
        $pet = (new VetmanagerApi(auth()->user()))->getOne(VetmanagerApi::PET, $id);
        (new VetmanagerApi(auth()->user()))->delete(VetmanagerApi::PET, $id);
        return redirect("clients/{$pet['owner_id']}");
    }
}
