<?php

namespace App\Http\Controllers;

use App\Models\OrderInstallation;
use Illuminate\Http\Request;

class OrderInstalltaionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order_intall = new OrderInstallation();
        return response()->json($order_intall->all());
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
        $order_intall = new OrderInstallation();
        $order_intall->name = $request->name;
        $order_intall->phone = $request->phone;
        if ($request->text) {
            $order_intall->text = $request->text;
        }
        $order_intall->save();
        return redirect("http://localhost:5173/service/installation");
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
        $order_intall = new OrderInstallation();
        $order_intall->find($id)->delete();
    }
}
