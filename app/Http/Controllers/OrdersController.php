<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\Order\OrderResource;

class OrdersController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        return Order::create($data) ? 'successfully' : 'bad';
    }

    public function index()
    {
        return OrderResource::collection(Order::get());
    }

    public function delete(Order $order)
    {
        $order->delete();

        return response();
    }
}
