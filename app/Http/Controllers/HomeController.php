<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function upload_photo(Request $request){
        if($request->hasFile('target')){
            $target = new \App\Target;
            $id = $target->id;
            $photo = $request->file('target');
            $filename = $id . '_' . time() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->save( public_path('/uploads/targets/' . $filename ) );

            $name = $request->input('name');
            $age = $request->input('age');
            $gender = $request->input('gender');

            $target->photo = $filename;
            $target->name = $name;
            $target->age = $age;
            $target->gender = $gender;
            $target->save();
        }

      return view('home');
  }
}
