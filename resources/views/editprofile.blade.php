@extends('layouts.app')

@section('content')
<link href="{{ asset('css/background.css') }}" rel="stylesheet">

<div class="container" id="profile">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel">
            <div class="panel-heading"><h3>Update Your Profile</h3></div>

            <div class="panel-body">
              <form enctype="multipart/form-data" action="/profile" method="POST">
                <div class="form-group">
                  <input type="file" name="avatar">
                </div>

                <div class="form-group">
                  <label for="name" >Name</label>
                  <input type="text" name="name" value="{{$user->name}}" id="inputName" class="form-control" placeholder="Your Name" required autofocus>
                </div>
                <div class="form-group">
                  <label for="age">Age</label>
                  <input type="number" name="age" value="{{$user->age}}" min=1 id="inputAge" class="form-control" placeholder="Your Age" required autofocus>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <input type="radio" name="gender" value="male"> Male
                    <input type="radio" name="gender" value="female"> Female
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="pull-right btn btn-block btn-primary">
              </form>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
