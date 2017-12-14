@extends('layouts.app')

@section('content')
<link href="{{ asset('css/background.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading"><h4>{{ $search->target->name }} {{ $search->created_at }}</h4></div>
                <div class="panel-body">
                  <div>
                      Result
                      <br>
                      <img src="https://d136usn7jnoe61.cloudfront.net/pictures/19798/s2n_0001_p1c0ihn7a7nn18k94261q9hrnh5.jpg" style="height:300px;">
                      <img src="https://d136usn7jnoe61.cloudfront.net/pictures/19798/s2n_0002_p1c0ihn7a81ltl15h5ks718k6125f7.jpg" style="height:300px;">

                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
