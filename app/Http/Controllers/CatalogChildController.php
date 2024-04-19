<?php

namespace App\Http\Controllers;

use App\Models\CatalogChild;
use App\Models\Furniture;
use Illuminate\Http\Request;

class CatalogChildController extends Controller
{
    public function index()
    {
        return response()->json(CatalogChild::all());
    }
    public function getFurniture($id)
    {
        $catalog_child = new CatalogChild();
        return  response()->json($catalog_child->find($id)->getFurniture);
    }
    public function getFurnitureWithTrash($id)
    {
        $catalog_child = new CatalogChild();
        $furniture = new Furniture();
        $catalog_child->find($id);
        $furniture_trash = [];
        foreach ($furniture->onlyTrashed()->get() as $item) {
            if ($item->catalog_child_id == $id) {
                array_push($furniture_trash, $item);
            }
        }
        return  response()->json($furniture_trash);
    }
    public function store(Request $request)
    {
        $catalog_child = new CatalogChild();
        $catalog_child->name = $request->name;
        $catalog_child->url = $request->url;
        $catalog_child->catalog_id = $request->id;
        $ok = $catalog_child->save();
        if ($ok) {
            return $catalog_child->all()->last();
        }
        // if (count($request->children)) {
        //     $newChildren = [];
        //     foreach ($request->children as $child) {
        //         $newChild = [
        //             "name" =>  $child['text'],
        //             "url" => $child['url'],
        //             "catalog_id" => $request->parentId
        //         ];
        //         array_push($newChildren,  $newChild);
        //     }
        //     $catalog_child->insert($newChildren);
        //     return 'Данные успешно сохранены';
        // } else {
        //     return  'Ошибка при обработке данных';
        // }
    }
    public function update(string $id,  Request $request)
    {
        $catalog_child = CatalogChild::find($id);
        $catalog_child->catalog_id = $request->id;
        $catalog_child->name = $request->name;
        $catalog_child->url = $request->url;
        $catalog_child->update();
        if ($catalog_child) {
            return response()->json($catalog_child);
        } else {
            return response()->json('Обновление не было успешным');
        }
    }

    public function getCatalogChildren(Request $request, string $id)
    {
        $childrenAll =  CatalogChild::where('catalog_id', $id)->get();

        $children = CatalogChild::where('catalog_id', $id)->skip($request->page . 0)->take($request->limit)->get();

        $totalPages = [
            "counter" => count($childrenAll),
        ];
        if ($request->page == 0) {
            $children->push($totalPages);
        }
        return response()->json($children);
    }
    public function destroy(string $id)
    {
        $deleted = CatalogChild::find($id)->delete();
        if ($deleted) {
            return response()->json('Товар успешно удален');
        } else {
            return response()->json('Товар не был удален');
        }
    }
}
