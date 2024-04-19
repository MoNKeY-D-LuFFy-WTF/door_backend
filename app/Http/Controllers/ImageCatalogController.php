<?php

namespace App\Http\Controllers;

use App\Models\CatalogImage;
use App\Models\Door;
use App\Models\DoorColor;
use App\Models\DoorStatus;
use App\Models\Furniture;
use Illuminate\Http\Request;

class ImageCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {

        $catalog_img = new CatalogImage();
        $furniture = new Furniture();
        $door_status = new DoorStatus();
        $door_colors = new DoorColor();
        $status_find =   $door_status->all()->where("name", $request->title)->first();
        $furniture_find = $furniture->all()->where("title", $request->title)->first();
        $door_color_find =  $door_colors->all()->where("name", $request->title)->first();

        if ($furniture_find !== null) {
            if ($furniture_find->catalog_img_id == $id) {
                return response()->file(public_path("storage/uploads/furnitures/" . $catalog_img->find($id)->name));
            } else {
                return response()->json("Error");
            }
        } else if ($status_find !== null) {
            return response()->file(public_path("storage/uploads/door_status/" . $catalog_img->find($id)->name));
        } else if ($door_color_find !== null) {
            return response()->file(public_path("storage/uploads/doors/" . $catalog_img->find($id)->name));
        }
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
