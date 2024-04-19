<?php

namespace App\Http\Controllers;

use App\Models\CatalogImage;
use App\Models\DoorStatus;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class DoorStatusController extends Controller
{
    public function index()
    {
        return response()->json(DoorStatus::all());
    }


    public function store(Request $request)
    {
        $door_status = new DoorStatus();
        $catalog_img = new CatalogImage();
        if ($request->file('image')) {
            $user_image =  $request->file('image');
            $img = Image::read($user_image->getRealPath());
            $img_id = count($door_status->withTrashed()->get()) + 1;
            $filename = $img_id . '_door_status.' . $user_image->getClientOriginalExtension();
            $path = public_path('storage/uploads/door_status/' .  $filename);
            $img->save($path);
            $catalog_img->name = $filename;
            $catalog_img->save();
        }
        $door_Status_img_id = count($catalog_img->withTrashed()->get());
        $door_status->name = $request->name;
        $door_status->catalog_img_id = $door_Status_img_id;
        $door_status->save();
    }
}
