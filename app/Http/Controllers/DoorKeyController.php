<?php

namespace App\Http\Controllers;

use App\Models\DoorKey;
use Illuminate\Http\Request;

class DoorKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $door_key = new DoorKey();
        return response()->json($door_key->all());
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
    public function store(Request $request)
    {
        $door_key = new DoorKey();
        $door_key->name = $request->name;
        $door_key->phone = $request->phone;
        $door_key->email = $request->email;
        $door_key->text = $request->text;
        $door_key->save();
        return redirect("http://localhost:5173");
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
        $door_key = new DoorKey();
        $door_key->find($id)->delete();
    }
}
