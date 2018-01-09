@extends('layouts.app')

@section('content')

<link href="{{ asset('css/background.css') }}" rel="stylesheet">

@if ($errors->any())
    <div class="alert alert-danger alert-dismissable fade in">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
@endif
@if(Session::has('alert-success'))
<div class="alert_border">
  <div class="alert alert-success alert-dismissable fade in">
    {{ session('alert-success') }}
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  </div>
</div>
@endif
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
                    <div class="upload">
                      <h4>Upload Target's Photo</h4>
                      <form enctype="multipart/form-data" action="/home" method="POST">
                        <div class="form-group">
                          <input type="file" name="target">
                        </div>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="submit" value="search" class="pull-right btn btn-block btn-primary">
                      </form>
                    </div>
                    <div class="selectFromHistory">
                      <br> or <br>
                      <h4>Select from your history</h4>
                      <form enctype="multipart/form-data" action="/searchagain" method="POST">
                        <div class="form-group" style="color: #000;">
                          <select name="target_id">
                            <?php foreach ($search as $key => $value): ?>
                              <option value="{{ $value->target_id }}">ID: {{ $value->target_id }} Name: {{ $value->target->name }}</option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="name">Source url</label>
                          <input type="text" name="url" placeholder="Url of Siam2nite's Album or Facebook public page's album" id="inputName" class="form-control" autofocus>
                        </div>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="submit" value="search" class="pull-right btn btn-block btn-primary">
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
