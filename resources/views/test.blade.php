@extends('layouts.app')

@section('content')

<link href="{{ asset('css/background.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-heading"><h4>Search</h4></div>

                <div class="panel-body" >
                  <button type="button" onclick="loadDoc()">click</button>
                  <p id="demo"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadDoc() {
  document.getElementById("demo").innerHTML = 'clicked';
  $.ajax({
    url: '/home/result',
    type: 'GET',
    contentType: "application/json",
    data: {
      "target_id": 1,
      "csvName": '2.csv',
      "user_id": 1,
      "search_id": 15
    },
    complete: function(data){
      console.log(data);
    },
    success: function(data) {
        console.log(data);
    }
  });
}
</script>
@endsection
