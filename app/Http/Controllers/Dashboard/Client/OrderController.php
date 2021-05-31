<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        //
    } // End Of Index


    public function create(Client $client )
    {
        $categories = Category::with('products')->get();
       return view('dashboard.clients.orders.create',compact('client','categories'));
    } // End Of create

    public function store(Request $request)
    {
        //
    }// End Of store


    public function show(order $order)
    {
        //
    }// End Of show


    public function edit(Client $client,order $order)
    {
        //
    }// End Of edit


    public function update(Request $request, order $order, Client $client)
    {
        //
    }// End Of update


    public function destroy(Client $client,order $order)
    {
        //
    }// End Of destroy
}
