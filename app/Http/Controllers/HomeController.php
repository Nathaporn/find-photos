<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Image;
use Auth;
use File;
use App\Search;
use App\Target;
use App\Upload;
use App\URL;

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
            $filename = time() . '.' . $photo->getClientOriginalExtension();

            $upload = Upload::create([
              'user_id' => $user->id,
            ]);

            $path = public_path(). '/users/'.$user->id.'/uploads/'. $upload->id . '/train/';
            File::makeDirectory($path, $mode = 0777, true, true);
            Image::make($photo)->save( public_path('users/'.$user->id.'/uploads/'. $upload->id . '/train/' . $filename ) );

            $path = public_path(). '/users/'.$user->id.'/uploads/'. $upload->id . '/found/';
            File::makeDirectory($path, $mode = 0777, true, true);

            $pyscript = '../app/python/saveFace.py';
          //  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
            $cmd = "python $pyscript $user->id $upload->id";
            exec("$cmd", $output);

            return view('face', array('user' => $user, 'upload_id' => $upload->id, 'output' => $output[0]));
        }

        return view('home');
    }

    public function search(Request $request){
            $user = Auth::user();
            $photo = $request->input('photo');
            $name = $request->input('name');
            $age = $request->input('age');
            $gender = $request->input('gender');
            $upload_id = $request->input('upload_id');
            $url = $request->input('url');

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

            $url_row = URL::where('url', $url)->get();
            if(count($url_row)==0){
              $url_row = URL::create([
                'url' => $url,
              ]);
            }else{
              $url_row = $url_row[0];
            }

            $search = Search::create([
              'user_id' => $user->id,
              'target_id' => $target->id,
              'url_id' => $url_row->id,
            ]);

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
