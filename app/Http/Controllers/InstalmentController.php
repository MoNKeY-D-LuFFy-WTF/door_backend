<?php

namespace App\Http\Controllers;

use App\Models\Instalment;
use Illuminate\Http\Request;

class InstalmentController extends Controller
{

    public function index()
    {
        $instalment = new Instalment();
        return response()->json($instalment->all());
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
        $instalment = new Instalment();
        $instalment->name = $request->name;
        $instalment->number = $request->phone;
        if ($request->text) {
            $instalment->text = $request->text;
        }
        $instalment->save();
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
        $instalment = new Instalment();
        $instalment->find($id)->delete();
    }
}
