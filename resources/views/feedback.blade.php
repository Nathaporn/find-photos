@extends('layouts.app')

@section('content')
<link href="{{ asset('css/background.css') }}" rel="stylesheet">
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

<div class="container">
  <div class="row">
      <div class="col-md-12">
          <div class="panel">
              <div class="panel-heading"><h4>Feedback</h4></div>
              <div class="panel-body">
                Please select the photos of your target.
              </div>
                  <div class="panel-body">
                    <form action="{{ route('sendFeedback') }}" method="POST">
                      {{ csrf_field() }}
                      <?php
                        $unmatch = array();
                        $dir = glob("./targets/$search->target_id/unmatch/*.csv");
                        foreach ($dir as $key => $value) {
                          $file = fopen($value,"r");
                          while(! feof($file)){
                            $line = fgetcsv($file);
                            array_push($unmatch, $line[0]);
                          }
                          fclose($file);
                        }

                        $file = fopen("./targets/".$search->target_id."/result/".$search->result,"r");

                        while(! feof($file))
                          {
                            $line = fgetcsv($file);
                            if(!in_array($line[0], $unmatch) && $line[0] != '' && $line[0] != 'url_result'){
                            ?>
                            <div class="thumnails">
                              <input type="checkbox" name="match[]" value="{{$line[0]}}">
                              <a href="{{$line[0]}}" data-fancybox="images" data-caption="">
                              	<img class="small_img" src="{{$line[0]}}" alt=''>
                              </a>
                            </div>
                        <?php
                          }
                         }

                        fclose($file);
                      ?>
                    <input type="hidden" name="search_id" value="{{$search->id}}">
                    <input type="hidden" name="from" value="{{$from}}">
                  <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
      </div>
    </div>
  </div>
</div>

@endsection
