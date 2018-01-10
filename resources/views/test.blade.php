@extends('layouts.app')

@section('content')

<link href="{{ asset('css/background.css') }}" rel="stylesheet">
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

<div class="container-fluid bg-1 text-center" id="loadscreen">
  <img src="/uploads/avatars/default.jpg" style="width:350px; height:350px; border-radius:50%; margin-top: 20px;" alt="Who">
  <h3>This process may take a few minutes. Please wait.</h3>
  <div class="loader"></div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading"><h4>Result</h4></div>
                <div class="panel-body" id="result_panel"></div>
                <div class="panel-body">
                  <form action="{{ route('feedback') }}" method="GET" onsubmit="return confirm('Summitting feedback will sent you to home page, but you can find the result again at your searching history. Are you sure you want to leave this page?');">
                    {{ csrf_field() }}
                    <input type="hidden" name="search_id" value="" id="from">
                    <input type="hidden" name="from" value="home">
                    If you want to give us a feedback to improve accuracy rate
                    <button type="submit" class="btn btn-primary btn-sm">
                      Click!
                    </button>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>

<script>
window.onload = function() {
  $(".panel").hide();
  var target_id = <?php echo $target->id; ?>;
  var search_id = <?php echo $search->id; ?>;
  var csvName = "<?php echo $search->url->csv; ?>";
  var user_id = <?php echo $user->id; ?>;

  $.ajax({
    url: '/home/result',
    type: 'GET',
    contentType: "application/json",
    data: {
      "target_id": target_id,
      "csvName": csvName,
      "user_id": user_id,
      "search_id": search_id
    },
    complete: function(data){
      console.log("completed");
      console.log(data);
    },
    success: function(data) {
      $("#loadscreen").hide();
      console.log("success")
      console.log(data);
      var json = $.parseJSON(data);
      console.log(json.output);
      $("#from").attr("value", json.search_id);
      for (var i = 1; i <= json.output; i++) {

        $("#result_panel").append('<div class="thumnails"><a href="" id="atmp" data-fancybox="images" data-caption=""><img class="small_img" src="" alt="" id="tmp"></a></div>');
        document.getElementById("tmp").id = "img"+i;
        $("#img"+i).attr("src", json.file[i]);
        document.getElementById("atmp").id = "a"+i;
        $("#a"+i).attr("href", json.file[i]);
      }
      $(".panel").fadeIn();
      // console.log(json);
    }
  });
}
</script>
@endsection
