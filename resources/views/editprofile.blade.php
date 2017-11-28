@extends('layouts.app')

@section('content')
<div class="container" id="profile">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form enctype="multipart/form-data" action="/profile" method="POST">
              <label>Update Profile Image</lable>
              <input type="file" name="avatar">
              <label>Update your profile</lable>
              <table>
                <tr>
                  <td>Name : </td>
                  <td><input type="text" name="name" value="{{$user->name}}"></td>
                </tr>
                <tr>
                  <td>Age : </td>
                  <td><input type="number" name="age" min="1" value="{{$user->age}}"></td>
                </tr>
                <tr>
                  <td>Gender : </td>
                  <td><input type="radio" name="gender" value="male" checked> Male</td>
                  <td><input type="radio" name="gender" value="female"> Female</td>
                </tr>
              </table>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="submit" class="pull-right btn btn-small btn-primary">
            </form>
        </div>
    </div>
</div>

@endsection
