<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:products_read'])->only('index');
        $this->middleware(['permission:products_create'])->only('create');
        $this->middleware(['permission:products_update'])->only('edit');
        $this->middleware(['permission:products_delete'])->only('destroy');
    }// end of construct
    public function index(Request $request)
    {
      $categories =  Category::all();
        $products = Product::when($request->search,function($q) use($request){

                return $q->WhereTranslationLike('name','%' . $request->search . '%')
                          ->orWhereTranslationLike('description','%' . $request->search . '%');
        })->when($request->category_id ,function($q) use($request) {
            return $q->where('category_id',$request->category_id);
        })->latest()->paginate(5);
       return view('dashboard.products.index',compact('products','categories'));
    }// end of index

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create',compact('categories'));
    } // end of create

    public function store(Request $request)
    {
       $rules = [
           'category_id' => 'required'
       ];
       foreach(config('translatable.locales') as $locale) {
           $rules += [$locale . '.name' => 'required|unique:product_translations,name'];
           $rules += [$locale . '.description' => 'required'];
       }
       $rules += [
           'purchase_price'  => 'required|numeric',
           'sale_price'  => 'required|numeric',
           'stock'  => 'required|numeric',
       ];

       $request->validate($rules);

        $request_data = $request->all();


        if($request->image) {
            // To Resize Image and Sava The Width And Height Togathers
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    // Uploads A image to director file and hash the name info folder
                    // Public_path in filessystem in config folder
                })->save(public_path('uploads/product_images/' . $request->image->hashName()));
            // Hash Name Of Image to Be Unique
            $request_data['image'] = $request->image->hashName();
        }// end of id

        Product::create($request_data);
        session()->flash('success',__('site.add_successfully'));
        return redirect()->route('dashboard.products.index');

    } // end of store





    public function edit(Product $product)
    {
       $categories = Category::all();

       return view('dashboard.products.edit',compact('product','categories'));
    }// end of edit


    public function update(Request $request, Product $product)
    {
        $rules = [
            'category_id' => 'required'
        ];
        foreach(config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]];
            $rules += [$locale . '.description' => 'required'];
        }
        $rules += [
            'purchase_price'  => 'required|numeric',
            'sale_price'  => 'required|numeric',
            'stock'  => 'required|numeric',
        ];

         $request_data = $request->except(['image']);;

        if($request->image) {
            if($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            }

            // To Resize Image and Sava The Width And Height Togathers
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    // Uploads A image to director file and hash the name info folder
                    // Public_path in filessystem in config folder
                })->save(public_path('uploads/product_images/' . $request->image->hashName()));
            // Hash Name Of Image to Be Unique
            $request_data['image'] = $request->image->hashName();
        }

        $request->validate($rules);



        $product->update($request_data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');

    } // end of update


    public function destroy(Product $product)
    {
        if($product->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
        }
        $product->delete();
        session()->flash('success',__('site.delete_successfully'));
        return redirect()->route('dashboard.products.index');
    } // end of destroy
}// end of controller
