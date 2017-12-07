@extends('layouts.app')

@section('content')
<link href="{{ asset('css/background.css') }}" rel="stylesheet">

<div class="container" id="profile">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <img src="/uploads/avatars/{{ $user->avatar }}"
              style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
            <h2>{{ $user->name }}'s Profile</h2>
            <div>
                <table>
                  <tr>
                    <td>Name : {{ $user->name }}</td>
                  </tr>
                  <tr>
                    <td>Age : {{ $user->age }}</td>
                  </tr>
                  <tr>
                    <td>Gender : {{ $user->gender }}</td>
                  </tr>
                  <tr>
                    <td><a href="{{ route('editprofile') }}" >
                          <button type="button" class="btn btn-small btn-primary">Edit Profile</button>
                        </a>
                    </td>
                  </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
