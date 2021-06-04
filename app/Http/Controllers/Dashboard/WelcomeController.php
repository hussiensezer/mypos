<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{

    public function index()
    {
        $product_count =  Product::count();
        $order_count =  Order::count();
        $category_count =  Category::count();
        $client_count =  Client::count();
        $user_count =  User::whereRoleIs('admin')->count();
        $sales_data = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total_price'),
        )->groupBy('month')->get();


        return view("dashboard.welcome",compact('product_count','order_count','category_count','client_count','user_count','sales_data'));
    }//end of index
}// end of controller
