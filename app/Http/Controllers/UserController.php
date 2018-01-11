<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use File;
use Image;
use App\Search;
use App\Upload;

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

    public function multipleUpload(Request $request){
        $user = Auth::user();
        $search_id = $request->input('search_id');
        $search = Search::where('id', $search_id)->first();

        if($request->hasFile('target')){
            $photos = $request->file('target');

            $upload = Upload::create([
              'user_id' => $user->id,
            ]);

            $path = public_path(). '/users/'.$user->id.'/uploads/'. $upload->id . '/train/';
            File::makeDirectory($path, $mode = 0777, true, true);

            $path = public_path(). '/users/'.$user->id.'/uploads/'. $upload->id . '/found/';
            File::makeDirectory($path, $mode = 0777, true, true);

            foreach ($photos as $key => $photo) {
              $filename = time() . '.' . $photo->getClientOriginalExtension();
              Image::make($photo)->save( public_path('users/'.$user->id.'/uploads/'. $upload->id . '/train/' . $filename ) );
            }
            $pyscript = '../app/python/saveFace.py';
            $cmd = "python $pyscript $user->id $upload->id";
            exec("$cmd", $output);

            return view('addface', array('user' => $user, 'upload_id' => $upload->id, 'search' => $search, 'target' => $search->target));
        }
        return redirect('/profile/history/'.$search_id);
    }

    public function addTrainingPhotos(Request $request){
      $target_id = $request->input('target_id');
      $search_id = $request->input('search_id');
      $photos = $request->input('photos');
      $dir = glob("./targets/$target_id/train/*.*");
      $name = count($dir)-1;
      foreach ($photos as $key => $photo) {
        $path_splt = explode (".",$photo);
        copy($photo, './targets/'. $target_id . '/train/' . $name . '.' . $path_splt[count($path_splt)-1]);
        $name = $name + 1;
      }
      return redirect('/profile/history/'.$search_id);
    }
}
