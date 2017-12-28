<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Image;
use App\Search;

class UserController extends Controller
{
    //
    public function profile(){
        return view('profile', array('user' => Auth::user()));
    }

    public function edit_profile(){
        return view('editprofile', array('user' => Auth::user()));
    }

    public function history(){
        $user = Auth::user();
        $search = $user->searches;
        return view('history', array('user' => $user, 'search' => $search));
    }

    public function history_detail($id){
      $user = Auth::user();
      $search = Search::where('id', $id)->first();
      return view('historydetail', array('user' => $user, 'search' => $search));
      //return view('history', array('user' => $user, 'search' => $search, 'id' => $id,));
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

        return redirect()->route('profile');
    }
}
