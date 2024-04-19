<?php

namespace App\Http\Controllers;

use App\Models\DoorThick;
use Illuminate\Http\Request;

class DoorThikController extends Controller
{
    public function index()
    {
        return response()->json(DoorThick::all());
    }
    public function store(Request $request)
    {
        $door_thick = new DoorThick();
        $door_thick->name =  $request->name;
        $door_thick->save();
    }
}
