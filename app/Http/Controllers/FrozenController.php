<?php

namespace App\Http\Controllers;

use App\Models\Frozen;
use Illuminate\Http\Request;

class FrozenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $frozen = new Frozen();
        return response()->json($frozen->all());
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
        $frozen = new Frozen();
        $frozen->name = $request->name;
        $frozen->phone = $request->phone;
        $frozen->save();
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
        $frozen = new Frozen();
        $frozen->find($id)->delete();
    }
}
