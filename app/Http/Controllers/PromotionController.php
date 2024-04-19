<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = new Promotion();
        return response()->json($promotions->all());
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
        $promotions = new Promotion();
        if ($request->hasFile('image')) {
            $id = count($promotions->all()) + 1;
            $image = $request->file('image');
            $filename = $id . "_promotions." . $image->getClientOriginalExtension();
            $path = public_path('storage/uploads/promotions/' .  $filename);
            $img = Image::read($image->getRealPath());
            $img->resize(450, 305);
            $promotions->title = $request->title;
            $promotions->subtitle = $request->subtitle;
            $promotions->image = $filename;
            $promotions->text = $request->text;
            $promotions->date = $request->date;
            $img->save($path);
            $promotions->save();
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
        $promotions = new Promotion();
        if ($promotions) {
            $item = $promotions->find($id);
            return response()->json($item);
        } else {
            return response()->json('Error');
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
    public function getImg(Request $request, string $id)
    {
        $promotions = new Promotion();
        $image = $promotions->find($id)->image;
        if ($image === $request->name) {
            if ($image) {
                return response()->file(public_path('storage/uploads/promotions/' . $image));
            } else {
                return response()->json('Error');
            }
        }
    }
}
