<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class OrderApiController extends Controller
{
     public function totalOrders()
   {
        $id = auth()->user()->id;
        $orders = User::find($id)->order;
        return response()->json([
            "status" => 1,
            "message" => "Total User Orders",
            "data" => $orders
        ]);

   }
}
