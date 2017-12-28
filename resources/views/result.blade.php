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
              <div class="panel-heading"><h4>{{ $search->target->name }} {{ $search->created_at }}</h4></div>
              <div class="panel-body">
                <h4>Result</h4>
                We've found {{$found}} photos of your target.
                <br>
                  <div>
                  <?php
                    $file = fopen("./users/".$user->id."/targets/".$target->id."/result/".$search->result,"r");

                    while(! feof($file))
                      {
                        $line = fgetcsv($file);
                        if($line[0] != '' && $line[0] != 'url_result'){
                        ?>
                        <div class="thumnails">
                          <a href="{{$line[0]}}" data-fancybox="images" data-caption="">
                          	<img class="small_img" src="{{$line[0]}}" alt=''>
                          </a>
                        </div>
                  <?php
                      }
                     }

                    fclose($file);
                  ?>
                </div>
              </div>
              <div class="panel-body">
                <form action="{{ route('feedback') }}" method="GET">
                  {{ csrf_field() }}
                  <input type="hidden" name="search_id" value="{{$search->id}}">
                  <input type="hidden" name="from" value="home">
                  If you want to give us a feedback to improve accuracy rate
                  <button type="submit" class="btn btn-primary btn-sm">
                    Click!
                  </button>
              </form>
            </div>
        </div>
    </div>
  </div>
</div>

@endsection
