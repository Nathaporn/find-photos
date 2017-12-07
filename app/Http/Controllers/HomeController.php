<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Auth;
use File;
use App\Target;
use App\Search;

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

    public function search(Request $request){
        if($request->hasFile('target')){
            $user = Auth::user();
            $photo = $request->file('target');
            $name = $request->input('name');
            $age = $request->input('age');
            $gender = $request->input('gender');
            $filename = time() . '.' . $photo->getClientOriginalExtension();

            $target = Target::create([
                'name' => $name,
                'age' => $age,
                'gender' => $gender,
            ]);

            $target->save();

            $path = public_path(). '/users/'.$user->id.'/targets/'. $target->id . '/';
            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($photo)->save( public_path('users/'.$user->id.'/targets/'. $target->id . '/' . $filename ) );

            $search = Search::create([
              'user_id' => $user->id,
              'target_id' => $target->id,
            ]);
        }

      return view('home');
  }

  public function search_again(){
    return view('home');
  }
}
