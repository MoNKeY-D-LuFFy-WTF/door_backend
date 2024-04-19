<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\CatalogChild;
use App\Models\Door;
use App\Models\DoorColor;
use App\Models\DoorMaterial;
use App\Models\DoorOpenSystem;
use App\Models\DoorThick;
use App\Models\Furniture;
use Illuminate\Http\Request;

class GetProductsController extends Controller
{
    public function getProduct(Request $request, $parent_url, $child_url)
    {
        $catalog = new Catalog();
        $furniture = new Furniture();
        $catalog_child = new CatalogChild();
        $door = Door::with([
            'doorStatuse',
            'doorColor',
            'doorMaterials.material',
            'doorOpenSystem.openSystem',
            'doorThick.thick',
            'DoorCatalogChild'
        ]);
        if ($request->param === "furniture") {
            if ($child_url == "undefined" || $child_url == "/") {
                return response()->json(Furniture::all());
            } else {
                $parent_id = $catalog->where("url", "/$parent_url")->get()->first()->id;
                $furniture = $catalog_child->where("catalog_id", $parent_id)->where('url', "/$child_url")->get()->first()->getFurniture;
                return response()->json($furniture);
            }
        } else {
            if ($child_url == "undefined" || $child_url == "/") {
                $catalog = Catalog::where('url', "/$parent_url")->get()->first();
                $catalog_child = CatalogChild::where('catalog_id',  $catalog->id)->get();
                $ids = [];
                foreach ($catalog_child as $child) {
                    array_push($ids, $child->id);
                }
                $doors = $door->whereIn('catalog_child_id', $ids)->get();
                return response()->json($doors);
            } else {
                $catalog_child_door = $catalog_child->where('url', "/$child_url")->get()->first();
                $doors = $door->where('catalog_child_id',  $catalog_child_door->id)->get();
                return response()->json($doors);
            }
        }
    }
    public function getBasketProduct(Request $request)
    {
        $data_array = [];

        foreach ($request->localData as $item) {

            $door = Door::find($item['id']);
            $door->door_color = DoorColor::find($item['doorColorId']);
            $door->material = DoorMaterial::find($item['materialId']);
            $door->door_open_system = DoorOpenSystem::find($item['openSystemId']);
            $door->door_thick = DoorThick::find($item['thickDoorId']);
            $door->quantity = $item['quantity'];
            $door->price = $door->door_color->price;
            $door->price_discount = $door->price - ($door->price * $door->discount / 100);
            array_push($data_array, $door);
        }

        return response()->json($data_array);
    }
} {
}
