<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
   
    public function index() {

        $id = Auth::user()->id;

        $profile = User::find($id);

        return view('backend.profile.index',compact('profile'));

    }
    public function store(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();  
            $file->move(public_path('upload/admin_images'),$filename);
            $data->photo = $filename;

        }
        $data->save();


      
        return redirect()->back();


    }

   
//update password
public function update(Request $request)
{
    // Validate input fields
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|confirmed|min:8',  // Ensure new password is confirmed and at least 8 characters long
    ]);

    // Check if the old password matches the current password
    if (!Hash::check($request->old_password, auth()->user()->password)) {
        // Flash error message to the session if the old password is incorrect
        session()->flash('error', 'Your current password does not match our records.');
        return redirect()->back();
    }

    // Update the user's password
    User::whereId(auth()->user()->id)->update([
        'password' => Hash::make($request->new_password),
    ]);

    // Flash success message to the session after password update
    session()->flash('success', 'Your password has been updated successfully.');
    
    return redirect()->back();
}

public function updateEmail(Request $request)
{
    // Validate new email and confirm password
    $request->validate([
        'emailaddress' => 'required|email|unique:users,email', // Ensure the email is unique and valid
        'confirmemailpassword' => 'required', // Password is required for confirmation
    ]);

    // Check if the password is correct
    if (!Hash::check($request->confirmemailpassword, auth()->user()->password)) {
        // Flash error message if the password doesn't match
        session()->flash('error', 'The password you entered is incorrect.');
        return redirect()->back();
    }

    // Update user's email address
    $user = auth()->user();
    $user->email = $request->emailaddress;
    $user->save();

    // Flash success message upon successful email update
    session()->flash('success', 'Your email address has been updated successfully.');
    
    return redirect()->back();
}

}
