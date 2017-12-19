<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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
      /*
      $pyscript = '../app/python/saveFace.py';
    //  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
      $cmd = "python $pyscript 1 19";
      exec("$cmd", $output);
      echo "$output[0]";*/

        return view('home');
    }

    public function upload(Request $request){
        if($request->hasFile('target')){
            $user = Auth::user();
            $photo = $request->file('target');
            $name = $request->input('name');
            $age = $request->input('age');
            $gender = $request->input('gender');
            $url = $request->input('url');
            $filename = time() . '.' . $photo->getClientOriginalExtension();

            $search = Search::create([
              'user_id' => $user->id,
              'target_id' => 1,
              'url' => $url,
            ]);

            $path = public_path(). '/users/'.$user->id.'/uploads/'. $search->id . '/train/';
            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($photo)->save( public_path('users/'.$user->id.'/uploads/'. $search->id . '/train/' . $filename ) );

            $path = public_path(). '/users/'.$user->id.'/uploads/'. $search->id . '/found/';
            File::makeDirectory($path, $mode = 0777, true, true);

            $pyscript = '../app/python/saveFace.py';
          //  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
            $cmd = "python $pyscript $user->id $search->id";
            exec("$cmd", $output);

            return view('face', array('user' => Auth::user(), 'search_id' => $search->id, 'output' => $output[0]));
        }

        return view('home');
    }

    public function search(Request $request){
            $user = Auth::user();
            $photo = $request->input('photo');
            $name = $request->input('name');
            $age = $request->input('age');
            $gender = $request->input('gender');
            $search_id = $request->input('search_id');

            $path_splt = explode ("/",$photo);

            $target = Target::create([
                'name' => $name,
                'age' => $age,
                'gender' => $gender,
            ]);

            $path = public_path(). '/users/'.$user->id.'/targets/'. $target->id . '/train/';
            File::makeDirectory($path, $mode = 0777, true, true);
            copy($photo, 'users/'.$user->id.'/targets/'. $target->id . '/train/' . $path_splt[count($path_splt)-1]);
            //Image::make($photo)->save( public_path('users/'.$user->id.'/targets/'. $target->id . '/train/' . $filename ) );

            $path = public_path(). '/users/'.$user->id.'/targets/'. $target->id . '/match/';
            File::makeDirectory($path, $mode = 0777, true, true);

            $path = public_path(). '/users/'.$user->id.'/targets/'. $target->id . '/unmatch/';
            File::makeDirectory($path, $mode = 0777, true, true);

            $search = Search::where('id', $search_id)->first();
            $search->target_id = $target->id;
            $search->save();
/*
            $pyscript = '../app/python/saveFace.py';
          //  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
            $cmd = "python $pyscript $user->id $target->id";
            exec("$cmd", $output);
            echo "$output[0]";*/

            $pyscript = '../app/python/training.py';
            $cmd = "python $pyscript $user->id $target->id";
            exec("$cmd", $output);
            print($output[0]);

      return view('home');
  }

  public function search_again(){
    return view('home');
  }
}
