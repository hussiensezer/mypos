<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

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

        $users = User::whereRoleIs('admin')->where(function($q) use ($request) {


            return $q->when($request->search, function ($query) use ($request) {

                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })->latest()->paginate(5);
       return view("dashboard.users.index",compact('users'));
    }// End Of Index


    public function create()
    {
        return view("dashboard.users.create");
    }// End of Create


    public function store(Request $request)
    {


        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1',
        ]); // End of Validate


// Dont Join The None-crypt Password Must crypt it before send to database
        $request_data = $request->except(['password','password_confirmation','permissions','image']);

        // Decrypt  the password already
        $request_data['password'] = bcrypt($request -> password);

        if($request->image) {
            // To Resize Image and Sava The Width And Height Togathers
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    // Uploads A image to director file and hash the name info folder
                    // Public_path in filessystem in config folder
                })->save(public_path('uploads/user_images/' . $request->image->hashName()));
            // Hash Name Of Image to Be Unique
             $request_data['image'] = $request->image->hashName();
        }


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
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'image' => 'image',
            'permissions' => 'required|min:1',
        ]); // End of Validate


        // Dont Join The None-crypt Password Must crypt it before send to database
        $request_data = $request->except(['permissions','image']);

        if($request->image) {
            if($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
            }// end inner if

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    // Uploads A image to director file and hash the name info folder
                    // Public_path in filessystem in config folder
                })->save(public_path('uploads/user_images/' . $request->image->hashName()));

            // Hash Name Of Image to Be Unique
            $request_data['image'] = $request->image->hashName();

        }//end if user-image

        // Save the Data into database
        $user->update($request_data);
        $user->syncPermissions($request->permissions);

        //Add To Session Success to Return in Users Index Massages
        session()->flash('success', __('site.updated_successfully'));

        // back to Users Page
        return redirect()->route('dashboard.users.index');

    } // End Of Update


    public function destroy(User $user)
    {
        // If The user image not equal the default image
        if($user->image != 'default.png') {
            // unlink or delete if not equal default image
            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
        }// end if

            $user->delete();
            session()->flash('success',__('site.delete_successfully'));
            return redirect(route('dashboard.users.index'));
    }// destroy

}// End Of Controller
