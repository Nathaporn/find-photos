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
                <div class="panel-heading"><h4>Search details</h4></div>
                <div class="panel-body">
                  <div>
                    <h4>Details</h4>
                    Target's name: {{ $search->target->name }} <br>
                    Target's age: {{ $search->target->age }} <br>
                    Target's gender: {{ $search->target->gender }} <br>
                    Search date: {{ $search->created_at }} <br>
                    Url: {{ $search->url->url }} <br><br>
                    <h4>Result</h4>

                      <div>
                        <div>
                        <?php
                          $file = fopen("./users/".$user->id."/targets/".$search->target_id."/result/".$search->result,"r");

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

                </div>
              </div>
              <div class="panel-body">
                <form action="{{ route('feedback') }}" method="GET">
                  {{ csrf_field() }}
                  <input type="hidden" name="search_id" value="{{$search->id}}">
                  <input type="hidden" name="from" value="history">
                    If you want to give us a feedback to improve accuracy rate
                  <button type="submit" class="btn btn-primary btn-sm">
                    Click!
                  </button>
                </form>
              </div>
              <div class="panel-body">
                <h4>Search Again</h4>
                <form enctype="multipart/form-data" action="{{ route('search_again') }}" method="POST"
                onsubmit="return alert('This process must take some time, plese wait.');">
                  <div class="form-group">
                    <label for="name">URL</label>
                    <input type="text" name="url" placeholder="Url of Siam2nite's Album or Facebook public page's album" id="inputName" class="form-control" autofocus>
                  </div>
                  <input type="hidden" name="target_id" value="{{ $search->target_id }}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="submit" value="search" class="pull-right btn btn-block btn-primary">
                </form>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
