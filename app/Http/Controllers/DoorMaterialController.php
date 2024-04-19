<?php

namespace App\Http\Controllers;

use App\Models\DoorMaterial;
use Illuminate\Http\Request;

class DoorMaterialController extends Controller
{

    public function index()
    {
        return response()->json(DoorMaterial::all());
    }

    public function store(Request $request)
    {
        $door_material = new DoorMaterial();
        $door_material->name = $request->name;
        $door_material->save();
    }
    public function getMaterialColors(string $id)
    {
        $door_material = new DoorMaterial();
        return response()->json($door_material->find($id)->doorColors);
    }

}
