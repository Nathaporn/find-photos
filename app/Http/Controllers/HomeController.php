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
      // $csvN = "10.csv";
      // $url = "https://www.facebook.com/pg/onyxbkk/photos/?tab=album&album_id=1269385029858946";
      // $pyscript = '../app/python/getFacebookImages.py';
      // $cmd = "python $pyscript \"$url\" \"$csvN\"";
      // print($cmd);
      // exec("$cmd", $output1);
      // print($output1[0]);
      // $pyscript = '../app/python/predictSiam2nite.py';
      // $cmd = "python $pyscript 1 4 2.csv 5";
      // exec("$cmd", $output1);
      // print($output1[0]);
      /*$url = 'https://www.siam2nite.com/en/pictures/onyx-presents-aquafest-2017-at-onyx-18859';
      $pyscript = '../app/python/siam2nite.py';
      $cmd = "scrapy runspider $pyscript -a url=$url -o ./csv/1.csv";
      exec("$cmd", $output);*/

    /*  $pyscript = '../app/python/predictSiam2nite.py';
      $cmd = "python $pyscript 1 13";
      exec("$cmd", $output);
        echo "$output[0]";*/
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
            $url = trim($request->input('url'));

            $path_splt = explode ("/",$photo);

            $target = Target::create([
                'name' => $name,
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

            $path = public_path(). '/users/'.$user->id.'/targets/'. $target->id . '/result/';
            File::makeDirectory($path, $mode = 0777, true, true);

            $url_row = $this->getUrl($url);

            $search = Search::create([
              'user_id' => $user->id,
              'target_id' => $target->id,
              'url_id' => $url_row->id,
            ]);

            $search->result = $search->id.".csv";
            $search->save();

      return view('test',array('user' => $user, 'target' => $target, 'search' => $search));

      //return view('result',array('user' => $user, 'target' => $target, 'search' => $search, 'output' => $output1[0]));
  }

  public function result(){
    $user_id = $_GET['user_id'];
    $target_id = $_GET['target_id'];
    $csvName = $_GET['csvName'];
    $search_id = $_GET['search_id'];

    $pyscript = '../app/python/training.py';
    $cmd = "python $pyscript $user_id $target_id";
    exec("$cmd", $output);
    //print($output[0]);

    $pyscript = '../app/python/predict.py';
    $cmd = "python $pyscript $user_id $target_id $csvName $search_id";
    exec("$cmd", $output1);
    //print($output1[0]);

    $myObj = array('target' => $target_id, 'search' => $search_id, 'output' => $output1[0]);
    $myJSON = json_encode($myObj);

    return $myJSON;
    //return view('result',array('user' => $user, 'target' => $target, 'search' => $search, 'output' => $output1[0]));
  }

  public function search_again(Request $request){
    $user = Auth::user();
    $target_id = $request->input('target_id');
    $target = Target::where('id', $target_id)->first();
    $url = trim($request->input('url'));

    $url_row = $this->getUrl($url);

    $search = Search::create([
      'user_id' => $user->id,
      'target_id' => $target->id,
      'url_id' => $url_row->id,
    ]);

    $pyscript = '../app/python/training.py';
    $cmd = "python $pyscript $user->id $target->id";
    exec("$cmd", $output);
    //print($output[0]);

    $pyscript = '../app/python/predictSiam2nite.py';
    $cmd = "python $pyscript $user->id $target->id $url_row->csv $search->id";
    exec("$cmd", $output1);
    //print($output1[0]);

    $search->result = $search->id.".csv";
    $search->save();
    return view('result',array('user' => $user, 'target' => $target, 'search' => $search, 'output' => $output[0]));
  }

  private function getUrl($url){
    $url_row = URL::where('url', $url)->get();
    //echo count($url_row);
    if(count($url_row)==0){
      $url_row = URL::create([
        'url' => $url,
      ]);
      $csv_name = $url_row->id . '.csv';

      $this->fetchPhotos($csv_name, $url);
      //echo $csv_name;
      $url_row->csv = $csv_name;
      $url_row->save();
    }else{
      $url_row = $url_row[0];
      //echo $url_row->id;
    }

    return $url_row;
  }

  private function fetchPhotos($csv_name, $url){
    if (strpos($url, 'www.facebook.com') !== false) {
      $pyscript = '../app/python/getFacebookImages.py';
      $cmd = "python $pyscript \"$url\" \"$csv_name\"";
      exec("$cmd", $output1);
    }else if(strpos($url, 'www.siam2nite.com') !== false){
      $pyscript = '../app/python/siam2nite.py';
      $cmd = "scrapy runspider $pyscript -a url=$url -o ./csv/$csv_name";
      exec("$cmd", $output);
    }
  }
}
