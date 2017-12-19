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

                    <h4>Upload Target's Photo</h4>
                    <form enctype="multipart/form-data" action="/home" method="POST">
                      <div class="form-group">
                        <input type="file" name="target">
                      </div>
                      <div class="form-group">
                        <label for="name">URL</label>
                        <input type="text" name="url" placeholder="Source URL of photos" id="inputName" class="form-control" autofocus>
                      </div>
                      <!--<div class="form-control">
                        <label for="source">Select source of photos</label>
                        <select class="form-control" id="source">
                          <option>Facebook</option>
                          <option>Siam2Night</option>
                        </select>
                      </div>-->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" value="search" class="pull-right btn btn-block btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
