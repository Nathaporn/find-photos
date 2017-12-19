@extends('layouts.app')

@section('content')

<link href="{{ asset('css/background.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-12">
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
                        <table class="table table-striped" id="search_table">
                          <col width="300">
                          <col width="1000">
                          <col width="50">
                          <?php foreach ($dir as $key => $value): ?>
                            <tr>
                              <td>
                              <div>
                                <img src="{{$value}}" style="width:200px; height:200px; margin:25px;">
                              </div>
                              </td>
                              <td>
                              <div>
                                <form enctype="multipart/form-data" action="/home/result" method="POST">
                                  <div class="form-group">
                                    <label for="name" >Name</label>
                                    <input type="text" name="name" placeholder="Enter Name" id="inputName" class="form-control" placeholder="Your Name" autofocus>
                                  </div>
                                  <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" name="age" placeholder="Enter Age" min=1 id="inputAge" class="form-control" placeholder="Your Age" autofocus>
                                  </div>
                                  <div class="form-group">
                                    <label for="gender">Gender </label>
                                    <input type="radio" name="gender" value="male" checked> Male
                                    <input type="radio" name="gender" value="female"> Female
                                  </div>
                                  <input type="hidden" name="photo" value={{$value}}>
                                  <input type="hidden" name="search_id" value={{$search_id}}>
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <input type="submit" value="search" class="pull-left btn btn-primary">
                                </form>
                              </div>
                            </td>
                            <td>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </table>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
