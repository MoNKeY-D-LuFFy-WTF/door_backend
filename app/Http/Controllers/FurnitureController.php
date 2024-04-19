<?php

namespace App\Http\Controllers;

use App\Models\CatalogImage;
use App\Models\Furniture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class FurnitureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $furniture = new Furniture();
        $catalog_img = new CatalogImage();
        if ($request->hasFile('image')) {
            $id = count($furniture->withTrashed()->get()) + 1;
            $image = $request->file('image');
            $filename = $id . "_furniture." . $image->getClientOriginalExtension();
            $path = public_path('storage/uploads/furnitures/' .  $filename);
            $img = Image::read($image->getRealPath());
            $furniture->catalog_child_id = $request->catalog_child_id;
            $furniture->title = $request->title;
            $catalog_img->name = $filename;
            $catalog_img->save();
            $furniture->catalog_img_id = count($catalog_img->withTrashed()->get());
            $furniture->price = intval($request->price);
            $img->resize(180, 135);
            $img->save($path);
            $furniture->save();
            return redirect('http://localhost:8080/#/admin/create');
        } else {
            return response('Erorr');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Furniture::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $title = $request->input('title');
        $price = $request->input('price');
        $furniture = Furniture::find($id);
        $catalog_img = new CatalogImage();
        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $filename = $id . "_furniture." . $image->getClientOriginalExtension();
            $find_img = $catalog_img->find($furniture->catalog_img_id);
            $path = public_path('storage/uploads/furnitures/' . $filename);
            $img = Image::read($image->getRealPath());
            // Удалить изображение
            Storage::disk('public')->delete("uploads/furnitures/" . $find_img->name);
            $find_img->name = $filename;
            $img->resize(180, 135);
            $img->save($path);
            $find_img->save();
            $furniture->title =  $title;
            $furniture->price = intval($price);
            $furniture->catalog_child_id = $furniture->catalog_child_id;
            $furniture->catalog_img_id = $furniture->catalog_img_id;
            $furniture->save();
            return response()->json($furniture);
        } else {
            $furniture->title =  $title;
            $furniture->price = intval($price);
            $furniture->catalog_child_id = $furniture->catalog_child_id;
            $furniture->catalog_img_id = $furniture->catalog_img_id;
            $furniture->save();
            return response()->json($furniture);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $furniture = new Furniture();
        $furniture_img = new CatalogImage();
        $furniture_find = $furniture->find($id);
        $furniture_img_find = $furniture_img->find($furniture_find->catalog_img_id);
        //Удалить изображение
        $furniture_img_find->delete();
        //Удалить продукт
        $furniture_find->delete();
    }
    public function refresh($id)
    {
        $furniture = new Furniture();
        $catalog_img = CatalogImage::onlyTrashed()->find($furniture->onlyTrashed()->find($id)->catalog_img_id)->restore();
        $furniture = Furniture::onlyTrashed()->find($id)->restore();
        if ($furniture && $catalog_img) {
            return response()->json('refreshed' . $furniture);
        }
    }
}
