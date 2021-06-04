<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {

       $orders = Order::whereHas('client',function($q) use($request){
            return $q->where('name','like', '%' . $request->search . '%')
                ->orWhere('phone','like','%'. $request->search . '%');
       })->latest()->paginate(5);

       return view("dashboard.orders.index",compact('orders'));
    } //End Of Index


    public function create()
    {
        //
    } //End Of create

    public function products(Order $order) {


     $products =   $order->products()->get();
        return view('dashboard.orders._products',compact('products','order'));
    }



    public function edit($id)
    {
        dd($id);
    } //End Of edit


    public function update(Request $request, $id)
    {
        //
    } //End Of update


    public function destroy(Order $order)
    {

        foreach($order->products  as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);


        }
        $order->delete();

        session()->flash('success',__('site.delete_successfully'));
        return redirect()->route('dashboard.orders.index');
    } //End Of destroy
}
