<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Image;
use App\Search;

class FeedbackController extends Controller
{
    //
    public function index(Request $request){
        $user = Auth::user();
        $search_id = $request->input('search_id');
        $search = Search::where('id', $search_id)->first();
        $target_id = $search->target_id;
        $result = $search->result;
        $from = $request->input('from');
        return view('feedback', array('user' => Auth::user(), 'search' => $search, 'from' => $from));
    }

    public function receiveFeedback(Request $request){
        $user = Auth::user();
        $from = $request->input('from');
        $match = $request->input('match');
        $search_id = $request->input('search_id');
        $search = Search::where('id', $search_id)->first();

        $filename = './users/'.$user->id.'/targets/'.$search->target_id.'/match/'.$search_id.'.csv';
        $file = fopen($filename,"w");

        if(empty($match)){
          fputcsv($file,explode(',',''));
        }
        else {
          foreach ($match as $line)
          {
            fputcsv($file,explode(',',$line));
          }
        }

        fclose($file);
        $request->session()->flash('alert-success', 'Feedback successfully sent. Thank you.');
        return redirect()->route($from);
    }

}
