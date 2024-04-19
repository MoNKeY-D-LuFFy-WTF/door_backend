<?php

namespace App\Http\Controllers;

use App\Models\DoorOpenSystem;
use Illuminate\Http\Request;

class DoorOpenSystemController extends Controller
{

    public function index()
    {
        return response()->json(DoorOpenSystem::all());
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        $door_open_system = new DoorOpenSystem();
        $door_open_system->name = $request->name;
        $door_open_system->save();
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
