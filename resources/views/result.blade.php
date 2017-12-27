@extends('layouts.app')

@section('content')
<link href="{{ asset('css/background.css') }}" rel="stylesheet">
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

<div class="container">
    <h4>Result</h4>
    We've found x photos of your target.
    <br>
      <?php
        $file = fopen("./csv/test.csv","r");

        while(! feof($file))
          {
            $line = fgetcsv($file);
            if($line[0] != ''){
            ?>
            <div class="thumnails">
              <a href="{{$line[0]}}" data-fancybox="images" data-caption="">
              	<img class="small_img" src="{{$line[0]}}" alt=''>
              </a>

            </div>
      <?php
          }
         }

        fclose($file);
      ?>
</div>

@endsection
