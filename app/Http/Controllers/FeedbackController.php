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

        $filename = './targets/'.$search->target_id.'/match/'.$search_id.'.csv';
        $file = fopen($filename,"w");
        fputcsv($file,explode(',','imagePath'));
        if(empty($match)){
          fputcsv($file,explode(',',''));
        }
        else {
          foreach ($match as $line)
          {
            fputcsv($file,explode(',',$line));
          }
        }

        $search->feedback = $search_id.'.csv';
        $search->save();

        $this->saveUnmatch($match, $search_id, $search->target_id);
        $this->extractMatch($search->target_id, $search->feedback);

        fclose($file);
        $request->session()->flash('alert-success', 'Feedback successfully sent. Thank you.');
        return redirect()->route($from);
    }

    private function saveUnmatch($match, $search_id, $target_id){
      $filename = './targets/'.$target_id.'/unmatch/'.$search_id.'.csv';
      $unmatch = fopen($filename,"w");
      $filename = './targets/'.$target_id.'/result/'.$search_id.'.csv';
      $result = fopen($filename,"r");
      while(! feof($result)){
        $line = fgetcsv($result);
        if (!in_array($line[0], $match)){
          fputcsv($unmatch,explode(',',$line[0]));
        }
      }
      fclose($unmatch);
      fclose($result);
    }

    private function extractMatch($target_id, $csvName){
      $pyscript = '../app/python/predictAndSave.py';
      $cmd = "python $pyscript $target_id $csvName";
      exec("$cmd", $output);
    }

}
