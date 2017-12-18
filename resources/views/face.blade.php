@extends('layouts.app')

@section('content')

<link href="{{ asset('css/background.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-heading"><h4>Search</h4></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Search id: {{$search_id}}
                    <br>
                    <?php
                      $dir = glob("./users/$user->id/uploads/$search_id/found/*.*");
                    ?>
                    @if (count($dir)==0)
                        Sorry, face not found.
                    @else
                      <?php foreach ($dir as $key => $value): ?>
                        <img src="{{$value}}" style="width:200px; height:200px; margin:25px;">
                      <?php endforeach; ?>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
