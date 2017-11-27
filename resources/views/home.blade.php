@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form enctype="multipart/form-data" action="/home" method="POST">
                      <label>Upload Target's Photo</lable>
                      <table>
                        <tr>
                          <input type="file" name="target">
                        </tr>
                        <tr>
                          <td>Name : </td>
                          <td><input type="text" name="name"></td>
                        </tr>
                        <tr>
                          <td>Age : </td>
                          <td><input type="number" name="age" min="1"></td>
                        </tr>
                        <tr>
                          <td>Gender : </td>
                          <td><input type="radio" name="gender" value="male" checked> Male</td>
                          <td><input type="radio" name="gender" value="female"> Female</td>
                        </tr>
                        <tr>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="search" class="pull-right btn btn-small btn-primary">
                        </tr>
                      </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
