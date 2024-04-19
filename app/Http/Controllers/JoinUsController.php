<?php

namespace App\Http\Controllers;

use App\Models\JoinUs;
use Illuminate\Http\Request;

class JoinUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $join = new JoinUs();
        return response()->json($join->all());
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
        $join = new JoinUs();
        $join->name = $request->name;
        $join->phone = $request->phone;
        $join->save();
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
        $join = new JoinUs();
        $join->find($id)->delete();
    }
}
