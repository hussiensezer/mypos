<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        //
    } // End Of Index


    public function create(Client $client , Order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);

       return view('dashboard.clients.orders.create',compact('client','categories','orders'));
    } // End Of create

    public function store(Request $request, Client $client)
    {


            $request->validate([
                'products' => 'required|array',
//                'quantities' => 'required|array'
            ]);


            $this->attach_order($request,$client);


        session()->flash('success',__('site.add_successfully'));
        return redirect()->route('dashboard.orders.index');

    }// End Of store


    public function show(order $order)
    {
        //
    }// End Of show


    public function edit(Client $client,order $order)
    {

        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.edit',compact('client','order','categories','orders'));
    }// End Of edit


    public function update(Request $request, Client $client, order $order)
    {
        $request->validate([
            'products' => 'required|array'
        ]);
        $this->detach_order($order);
        $this->attach_order($request,$client);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }// End Of update


    public function destroy(Client $client,order $order)
    {
        //
    }// End Of destroy

    private function attach_order($request, $client) {
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price =0;

        foreach($request->products as $id =>$quantity) {


            $product = Product::FindOrFail($id);

            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([

                'stock' => $product->stock - $quantity['quantity'],
            ]);

        }
        $order->update([

            'total_price' => $total_price,
        ]);
    } // End Attach Order

    private function detach_order($order) {
        foreach($order->products  as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);


        }
        $order->delete();
    }
}
