<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Image;

class UserController extends Controller
{
    //
    public function profile(){
        return view('profile', array('user' => Auth::user()));
    }

    public function edit_profile(){
        return view('editprofile', array('user' => Auth::user()));
    }

    public function update_avatar(Request $request){

      if($request->hasFile('avatar')){
          $avatar = $request->file('avatar');
          $user = Auth::user();
          $name = $user->name;
          $filename = $user->name . time() . '.' . $avatar->getClientOriginalExtension();
          Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );


          $user->avatar = $filename;
          $user->save();
      }

        return view('profile', array('user' => Auth::user()));
    }

    public function update_profile(Request $request){
        $user = Auth::user();

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $user = Auth::user();
            $name = $user->name;
            $filename = $user->name . time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );


            $user->avatar = $filename;
        }

        $name = $request->input('name');
        $age = $request->input('age');
        $gender = $request->input('gender');

        if($name != ''){
          $user->name = $name;
        }
        if($age != ''){
          $user->age = $age;
        }
        $user->gender = $gender;

        $user->save();

        return view('profile', array('user' => Auth::user()));
    }
}
