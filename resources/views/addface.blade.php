@extends('layouts.app')

@section('content')

<link href="{{ asset('css/background.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading"><h4>Whose photo do you want to search?</h4></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <br>



                    <?php
                      $dir = glob("./users/$user->id/uploads/$upload_id/found/*.*");
                    ?>
                        @if (count($dir)==0)
                            Sorry, face not found.
                        @else
                        <form action="{{ route('addFace') }}" method="POST">
                          {{ csrf_field() }}
                          <?php foreach ($dir as $key => $value):?>

                            <div >
                              <input type="checkbox" name="photos[]" value="{{$value}}">
                              <img src="../../{{$value}}" style="width:200px; height:200px; margin:25px;">
                            </div>
                          <?php endforeach; ?>
                        <input type="hidden" name="target_id" value="{{$target->id}}">
                        <input type="hidden" name="search_id" value="{{$search->id}}">
                        <div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                      @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
