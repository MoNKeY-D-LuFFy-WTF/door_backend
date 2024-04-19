<?php

namespace App\Http\Controllers;

use App\Models\MainBaner;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Termwind\Components\Raw;

class MainBanerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(MainBaner::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $banner = new MainBaner();
        if ($request->hasFile('image')) {
            $id = count($banner->all()) + 1;
            $image = $request->file('image');
            $filename = $id . "_main_banner." . $image->getClientOriginalExtension();
            $path = public_path('storage/uploads/banners/' .  $filename);
            $img = Image::read($image->getRealPath());
            $banner->title = $request->title;
            $banner->subtitle = $request->subtitle;
            $banner->image = $filename;
            $banner->url = $request->url;
            $img->save($path);
            $banner->save();
            return redirect('http://localhost:8080/#/admin/create');
        } else {
            return response('Erorr');
        }
    }
    public function getImg($id)
    {
        $banner = new MainBaner();
        return  response()->file(public_path('storage/uploads/banners/' . $banner->find($id)->image));
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
    }
}
