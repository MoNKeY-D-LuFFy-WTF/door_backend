<?php

namespace App\Http\Controllers;

use App\Models\Door;
use App\Models\DoorAndDoorThick;
use App\Models\DoorAndMaterialDoor;
use App\Models\DoorAndSystemOpenDoor;
use App\Models\DoorColor;
use App\Models\DoorCombo;
use App\Models\DoorMaterial;
use App\Models\DoorOpenSystem;
use App\Models\DoorStatus;
use App\Models\DoorThick;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class DoorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doors = Door::with([
            'doorColor',
            'doorMaterials.material.doorColors',
            'doorOpenSystem.openSystem',
            'doorThick.thick',
            'DoorCatalogChild'
        ])->get();
        return response()->json($doors);
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
        // Все таблицы с которыми работаем
        // return response()->json($request->form['materials']);
        $door_combo = new DoorCombo();
        $door = new Door();
        $door_and_material_doors = new DoorAndMaterialDoor();
        $door_and_system_open_doors = new DoorAndSystemOpenDoor();
        $door_and_door_thicks = new DoorAndDoorThick();
        $data = [];
        $door->name =  $request->form['name'];
        $door->door_statuse_id = intval($request->form['status']['id']);
        $door->door_color_id = intval($request->form['color']['id']);
        // Проверякм инпут радио значение и сахраняем
        if ($request->form['window'] == 'yes') {
            $door->window = 1;
        } else {
            $door->window = 0;
        }
        //Проверякм инпут радио значение и сахраняем
        if ($request->form['soung']  == "yes") {
            $door->soung = 1;
        } else {
            $door->soung = 0;
        }
        if ($request->form['discount']) {
            $door->discount = intval($request->form['discount']);
        }
        $door->price = intval($request->form['price']);
        if ($request->form['price_discount']) {
            $door->price_discount = intval($request->form['price_discount']);
        }
        $door->catalog_child_id = intval($request->form['catalog_child_id']);
        $door->url = $request->form['url'];

        //Сахраняем дверь
        $door->save();

        $door_id = Door::get()->last()->id;

        //Сахраняем комбо материалы
        $door_combo->combo = json_encode($request['form']);
        $door_combo->door_id =  intval($door_id);
        $door_combo->save();

        // Находим сохраненную дверь и обновляем связь с комбо материалами
        $doorToUpdate = Door::find($door_id);
        $doorToUpdate->door_combo_id = $door_combo->id;
        $doorToUpdate->save();


        //Сахраняем материалы покрытия в таблицу с связкой много ко многим
        foreach ($request->form['materials'] as $material) {
            $item =  [
                'door_id' => intval($door_id),
                'door_material_id' => intval($material['id']),
            ];
            array_push($data, $item);
        }
        $door_and_material_doors->insert($data);
        $data = [];
        //Сахраняем систему открывания в таблицу с связкой много ко многим
        foreach ($request->form['opens'] as $open) {
            $item =  [
                'door_id' => intval($door_id),
                'door_open_system_id' => intval($open['id']),
            ];
            array_push($data, $item);
        }
        $door_and_system_open_doors->insert($data);
        $data = [];
        //Сахраняем толщину стены в таблицу с связкой много ко многим
        foreach ($request->form['thicks'] as $thick) {
            $item =  [
                'door_id' => intval($door_id),
                'door_thick_id' => intval($thick['id']),
            ];
            array_push($data, $item);
        }
        $door_and_door_thicks->insert($data);
        return response()->json(Door::get()->last());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $door = Door::with([
            'combo',
            'doorStatuse',
            'doorColor',
            'doorMaterials.material.doorColors',
            'doorOpenSystem.openSystem',
            'doorThick.thick',
            'DoorCatalogChild'
        ])->where('id', $id)->first();
        $colors = [];
        foreach ($door->doorMaterials as $material) {
            foreach ($material->material->doorColors as $color) {
                array_push($colors, $color);
            }
        }
        $door['door_color_all'] = $colors;
        $door['combo']['combo'] = json_decode($door['combo']['combo'], true);
        return response()->json($door);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $door = Door::find($id);
        $door_combos = new DoorCombo();
        //Удаляем все старые записи
        // DoorCombo::where('door_id', $id)->destroy();
        DoorAndMaterialDoor::whereIn('door_id', [$id])->delete();
        DoorAndDoorThick::whereIn('door_id',  [$id])->delete();
        DoorAndSystemOpenDoor::whereIn('door_id', [$id])->delete();
        $door_combo =  $door_combos->where('door_id',  $id)->get()->first();
        $door_combo->combo = json_encode($request['form']);
        $door_combo->door_id = intval($id);
        $door_combo->update();
        if ($request['form']['discount']) {
            $door->discount = intval($request['form']['discount']);
        }
        $door->name = $request['form']['name'];
        $door->url = $request['form']['url'];
        $door->door_color_id = $request['form']['color']['id'];
        $door->catalog_child_id = intval($request['form']['catalog_child_id']);
        if ($request['form']['soung'] == 'yes' || $request['form']['soung'] == 1) {
            $door->soung = 1;
        } else {
            $door->soung = 0;
        }
        $door->price_discount = intval($request['form']['price_discount']);
        $door->price = intval($request['form']['price']);
        if ($request['form']['window'] == `yes` || $request['form']['window'] == 1) {
            $door->window = 1;
        } else {
            $door->window = 0;
        }
        $door->door_statuse_id = intval($request['form']['status']['id']);
        $door->update();
        $id = $door->id;
        $dataOfDoor = [];
        $door_and_material_doors = new DoorAndMaterialDoor();
        $door_and_door_thicks = new DoorAndDoorThick();
        $door_and_system_open_doors = new DoorAndSystemOpenDoor();
        foreach ($request['form']['materials'] as $material) {
            $item = [
                "door_material_id" => intval($material['id']),
                "door_id" => $id
            ];
            array_push($dataOfDoor, $item);
        }
        $door_and_material_doors->insert($dataOfDoor);
        $dataOfDoor = [];
        foreach ($request['form']['opens'] as $open) {
            $item = [
                "door_open_system_id" => intval($open['id']),
                "door_id" => $id
            ];
            array_push($dataOfDoor, $item);
        }
        $door_and_system_open_doors->insert($dataOfDoor);
        $dataOfDoor = [];
        foreach ($request['form']['thicks'] as $thick) {
            $item = [
                "door_thick_id" => intval($thick['id']),
                "door_id" => $id
            ];
            array_push($dataOfDoor, $item);
        }

        $door_and_door_thicks->insert($dataOfDoor);
        $dataOfDoor = [];
        return response()->json(Door::where('id', $id)->first());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $door = new Door();
        $door = Door::find($id);
        $deleted = $door->delete();
        if ($deleted) {
            return response()->json("Дверь успешно удален");
        } else {
            return response()->json("Дверь не был удален");
        }
    }
    public function getDoorWithMaterial(string $material_door, string $name)
    {
        $i = DoorMaterial::where('name', $material_door)->get()->first();
        $a =  DoorAndMaterialDoor::with(['material'])->where('door_material_id',  $i->id)->get()->first();
        $door = Door::with([
            'doorStatuse',
            'doorColor',
            'doorMaterials.material.doorColors',
            'doorOpenSystem.openSystem',
            'doorThick.thick',
            'DoorCatalogChild'
        ])->where('id', $a->door_id)->whereNot('name', $name)->get()->first();
        return response()->json($door);
    }
    public function getDoorsFromCatalogChildId(string $catalogChildId)
    {
        if ($catalogChildId) {
            $doors = Door::where('catalog_child_id', $catalogChildId)->with([
                'doorStatuse',
                'doorColor',
                'doorMaterials.material.doorColors',
                'doorOpenSystem.openSystem',
                'doorThick.thick',
                'DoorCatalogChild'
            ])->get();

            return response()->json($doors);
        }
    }
    public function trash(string $catalogChildId)
    {
        return response()->json(Door::onlyTrashed()->with([
            'doorStatuse',
            'doorColor',
            'doorMaterials.material.doorColors',
            'doorOpenSystem.openSystem',
            'doorThick.thick',
            'DoorCatalogChild'
        ])->where('catalog_child_id', $catalogChildId)->get());
    }
    public function trashReturn(string $id)
    {
        $door = Door::onlyTrashed()->where('id', $id)->get()->first()->restore();
        if ($door) {
            return response()->json('Дверь успешно востановлено');
        }
    }
    public function getDoorsWithCatalogChildId(Request $request, string $id)
    {
        $doorAll =  Door::where('catalog_child_id', $id)->get();

        $doors = Door::with([
            'combo',
            'doorStatuse',
            'doorColor',
            'doorMaterials.material.doorColors',
            'doorOpenSystem.openSystem',
            'doorThick.thick',
            'DoorCatalogChild'
        ])->where('catalog_child_id', $id)->skip($request->page . 0)->take($request->limit)->get();

        $totalPages = [
            "counter" => count($doorAll),
        ];
        if ($request->page == 0) {
            $doors->push($totalPages);
        }
        return response()->json($doors);
    }
    public function material()
    {
        $doorThicks = DoorThick::get();
        $doorMaterials = DoorMaterial::get();
        $doorOpenSystem = DoorOpenSystem::get();
        $doorStatuses = DoorStatus::get();
        $doorColors = DoorColor::get();
        $response = [
            'door_thicks' =>  $doorThicks,
            'door_materials' =>  $doorMaterials,
            'door_opens' =>  $doorOpenSystem,
            'door_statuses' =>  $doorStatuses,
            'door_colors' =>  $doorColors,
        ];
        // $doorMaterials = 
        return     $response;
    }
    public function basket(Request $request)
    {
        $response = [];
        foreach ($request->doors as $door) {

            $newDoor = Door::find($door['doorId']);
            $newDoor['color'] = DoorColor::find($door['colorId']);
            $newDoor['material'] = DoorMaterial::find($door['materialId']);
            $newDoor['open_system'] = DoorOpenSystem::find($door['open']);
            $newDoor['quantity'] = $door['quantity'];
            $newDoor['soung'] = $door['soung'];
            $newDoor['thick'] = DoorThick::find($door['thick']);
            $newDoor['window'] = $door['window'];
            $newDoor['isCombo'] = $door['isCombo'];
            if ($newDoor['soung'] == 1) {
                $soungPrice = 600;
            } else {
                $soungPrice = 0;
            }
            if ($newDoor['window'] == 1) {
                $windowPrice = 500;
            } else {
                $windowPrice = 0;
            }
            $newDoor['price_comp'] = 1 * ($newDoor['price'] + $newDoor['material']['price'] + $newDoor['color']['price'] + $newDoor['open_system']['price'] + $newDoor['thick']['price'] +  $windowPrice + $soungPrice);
            $newDoor['price_mobile'] =  $newDoor['quantity'] * ($newDoor['price'] + $newDoor['material']['price'] + $newDoor['color']['price'] + $newDoor['open_system']['price'] + $newDoor['thick']['price'] +  $windowPrice + $soungPrice);

            if ($newDoor['discount']) {
                $newDoor['price_comp_discount'] = round($newDoor['price_comp'] - ($newDoor['price_comp'] * $newDoor['discount'] / 100));
                $newDoor['price_mobile_discount'] =  $newDoor['quantity'] *  round($newDoor['price_comp'] - ($newDoor['price_comp'] * $newDoor['discount'] / 100));
            }
            if ($door['isCombo']) {
                $newDoor['price_comp'] = round($door['priceCombo'] +  ($door['priceCombo'] * $newDoor['discount'] / 100));
                $newDoor['price_mobile'] = $newDoor['price_comp'];
                $newDoor['price_comp_discount'] = $door['priceCombo'];
                $newDoor['price_mobile_discount'] = $door['priceCombo'];
            }
            array_push($response, $newDoor);
        }
        return response()->json($response);
    }
    public function find(String $name)
    {
        $doors = Door::with(['DoorCatalogChild.catalog'])->where('name', 'LIKE', '%' . $name . '%')->get();
        return response()->json($doors);
    }
}
