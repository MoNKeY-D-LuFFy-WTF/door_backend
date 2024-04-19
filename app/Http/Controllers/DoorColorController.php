<?php

namespace App\Http\Controllers;

use App\Models\CatalogImage;
use App\Models\DoorColor;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class DoorColorController extends Controller
{

    public function index()
    {
    }


    public function store(Request $request)
    {
        $door_color = new DoorColor();
        $catalog_img = new CatalogImage();
        if ($request->file('image')) {
            $image_user = $request->file('image');
            $img = Image::read($image_user->getRealPath());
            $filename_id = count($door_color->all()) + 1;
            $filename = $filename_id . '_door_color.' .  $image_user->getClientOriginalExtension();
            $path = public_path('storage/uploads/door_colors/' . $filename);
            $img->save($path);
            $door_color->image =  $filename;
        }
        if ($request->file('image_door')) {
            $image_user = $request->file('image_door');
            $img = Image::read($image_user->getRealPath());
            $filename_id = count($door_color->all()) + 1;
            $filename = $filename_id . '_door.' .  $image_user->getClientOriginalExtension();
            $path = public_path('storage/uploads/doors/' . $filename);
            $img->save($path);
            $catalog_img->name = $filename;
            $catalog_img->save();
        }
        $door_color->name = $request->name;
        $door_color->price = intval($request->price);
        $door_color->door_material_id = intval($request->door_material);
        $door_color->catalog_img_id = count($catalog_img->withTrashed()->get());
        $door_color->save();
        /*
        price
        image
        image_door
        door_material
        1*/
    }
    public function getImageColors(string $name)
    {
        return response()->file(public_path('storage/uploads/door_colors/' . $name));
    }
}
