<?php

namespace App\Http\Controllers;

use App\Models\UserClient;
use Illuminate\Http\Request;

class UserClientController extends Controller
{

    public function index()
    {
        return response()->json(UserClient::all());
    }


    public function store(Request $request)
    {
        if ($request->FormData && $request->productsData) {
            $user_client = new UserClient();
            $user_client->name = $request->FormData['name'];
            $user_client->email = $request->FormData['email'];
            $user_client->phone = $request->FormData['phone'];
            $user_client->total_price = $request->FormData['totalPrice'];
            $user_client->total_price_discount  = $request->FormData['totalPriceDiscount'];
            $user_client->clinet_goods = $request->productsData;
            $user_client->save();
            return 'Заявка принята спасибо за ваш выбор!';
        }
        return 'Ошибка сервера';
    }


    public function show(string $id)
    {
    }


    public function edit(string $id)
    {
    }


    public function update(Request $request, string $id)
    {
    }


    public function destroy(string $id)
    {
    }
}
