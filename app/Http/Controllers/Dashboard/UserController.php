<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct() {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');
        $this->middleware(['permission:users_delete'])->only('destroy');
    }

    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->when($request->search, function($query) use($request) {

                return $query->where('first_name','like','%' . $request->search .'%')

                    ->orWhere('last_name','like','%' . $request->search .'%')

                    ->orWhere('email','like','%' . $request->search .'%');
        })->latest()->paginate(5);
       return view("dashboard.users.index",compact('users'));
    }


    public function create()
    {
        return view("dashboard.users.create");
    }// End of Create


    public function store(Request $request)
    {


        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]); // End of Validate


// Dont Join The None-crypt Password Must crypt it before send to database
        $request_data = $request->except(['password','password_confirmation','permissions']);

        // Decrypt  the password already
        $request_data['password'] = bcrypt($request -> password);

        // Save the Data into database
        $user = User::create($request_data);
        $user->attachRole("admin");
        $user->syncPermissions($request->permissions);

        //Add To Session Success to Return in Users Index Massages
        session()->flash('success', __('site.add_successfully'));

        // back to Users Page
        return redirect()->route('dashboard.users.index');

    }//End Of Store




    public function edit(User $user)
    {
        return view("dashboard.users.edit",compact('user'));
    }// End Of Edit



    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]); // End of Validate


        // Dont Join The None-crypt Password Must crypt it before send to database
        $request_data = $request->except(['permissions']);
        // Save the Data into database
        $user->update($request_data);
        $user->syncPermissions($request->permissions);

        //Add To Session Success to Return in Users Index Massages
        session()->flash('success', __('site.updated_successfully'));

        // back to Users Page
        return redirect()->route('dashboard.users.index');

    }


    public function destroy(User $user)
    {
            $user->delete();
            session()->flash('success',__('site.delete_successfully'));
            return redirect(route('dashboard.users.index'));
    }// destroy
}// End Of Controller
