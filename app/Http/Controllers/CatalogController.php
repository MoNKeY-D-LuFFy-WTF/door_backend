<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\CatalogChild;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $catalog = new Catalog();
        $totalPages = count($catalog->all());
        if (!$request->page) {
            return response()->json($catalog->with(['catalog_child'])->get());
        }
        $response = $catalog->skip("$request->page" . 0)->take("$request->limit")->get();
        $totalPages = [
            "counter" => $totalPages,
        ];
        if ($request->page == 0) {
            $response->push($totalPages);
        }
        return response()->json($response);
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
        $catalog = new Catalog();
        $catalog->name = $request->name;
        $catalog->url = $request->url;
        $ok =  $catalog->save();
        if ($ok) {
            return response()->json(Catalog::all()->reverse()->first());
        } else {
            return "Ошибка товар не добавлен";
        }
        // if (count($request->children)) {
        //     $chldrenlist = [];
        //     foreach ($request->children as $item) {
        //         $itemCatalogChild = [
        //             "name" => $item['text'],
        //             "url" => $item['url'],
        //             "catalog_id" => $catalog->withTrashed()->orderBy('id', 'desc')->get()->first()->id
        //         ];
        //         array_push($chldrenlist, $itemCatalogChild);
        //     }
        //     $catalog_child->insert($chldrenlist);
        // } else {
        //     return 'Данные успешно сохранены но нет дочерных елементов';
        // }
        // return 'Данные успешно сохранены';
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

        $catalog = Catalog::find($id);
        $catalog->name = $request->name;
        $catalog->url = $request->url;
        $ok = $catalog->update();
        if ($ok) {
            return response()->json($catalog->where('id', $id)->get()->first());
        } else {
            return response()->json('Ошибка при изменении');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $name, string $params)
    {
        if ($params ==  "name") {
            $catalog = new Catalog();
            foreach ($catalog->all()->where("name", $name) as $item) {
                $item->delete();
            }
        } else if ($params ==  "name_child") {
            $catalog_child = new CatalogChild();
            foreach ($catalog_child->all()->where("name", $name) as $item) {
                $item->delete();
            }
        }
    }
    public function deleted(string $id)
    {
        $ok =  Catalog::find($id)->delete();
        if ($ok) {
            return 'Товар удален';
        } else {
            return 'Товар не удален';
        }
    }
}
