<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\category;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_create'])->only('create');
        $this->middleware(['permission:categories_update'])->only('edit');
        $this->middleware(['permission:categories_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::when($request->search,function($q) use($request){
            $q->where('name','like','%' . $request->search . '%');
        })->latest()->paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    }// End Of Index


    public function create()
    {
        return view("dashboard.categories.create");
    }// End Of Create


    public function store(Request $request)
    {

//        dd($request->all());
        $rules = [];

        foreach(config('translatable.locales') as $locale) {
            //ar.name
//            $rules += [$locale . '.*' => 'required' ];
            $rules += [$locale . '.name' => ['required',Rule::unique('category_translations' ,'name')] ];
        }

        $request->validate($rules);
        category::create($request->all());
        session()->flash('success',__('site.add_successfully'));
        return redirect()->route('dashboard.categories.index');
    }// End Of Store



    public function edit(category $category)
    {
        return view("dashboard.categories.edit",compact('category'));
    }// End Of Edit


    public function update(Request $request, category $category)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale) {
            //ar.name
//            $rules += [$locale . '.*' => 'required' ];
            $rules += [$locale . '.name' => ['required',Rule::unique('category_translations' ,'name')->ignore($category->id,'category_id')] ];
        }

        $request->validate($rules);
        $category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }// End Of Update


    public function destroy(category $category)
    {
        $category->delete();
        session()->flash('success',__('site.delete_successfully'));
        return redirect()->route('dashboard.categories.index');
    }// End Of Destroy

} // End Of Controller
