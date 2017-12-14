<?php
$uid = $_POST['uid'] ;
$tid = $_POST['tid'] ;
if($_POST['pyFunction'] == "runSiam2nite"){
  $pyscript = './python/siam2nite.py';
  #$url = 'https://www.siam2nite.com/en/pictures/onyx-presents-aquafest-2017-at-onyx-18859';
  $url = $_POST['url'];
  $cmd = "scrapy runspider $pyscript -a url=$url -o ./users/$uid/target/$tid/temp.csv";
  exec("$cmd", $output);
  print($output[0]);
}

else if($_POST['pyFunction'] == "helloPython"){
  $pyscript = './python/helloPython.py';
  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
  $cmd = "python $pyscript";
  exec("$cmd", $output);
  print($output[0]);
}

else if($_POST['pyFunction'] == "saveFace"){
  $pyscript = './python/saveFace.py';
  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
  $cmd = "python $pyscript $uid $tid";
  exec("$cmd", $output);
  print($output[0]);
}

else if($_POST['pyFunction'] == "trainFirstTime"){
  $pyscript = './python/training.py';
  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
  $cmd = "$python $pyscript $uid $tid";
  exec("$cmd", $output);
  print($output[0]);
}

else if($_POST['pyFunction'] == "predictSiam2nite"){
  // predict image from csv file
  $pyscript = './python/predictSiam2nite.py';
  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
  $cmd = "python $pyscript $uid $tid";
  exec("$cmd", $output);
  print($output);
}


//system("C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe ./testResponse.py")
/*
  $pyscript = './testResponse.py';
  $python = 'C:\Users\USER\AppData\Local\Programs\Python\Python36-32\python.exe';
  $cmd = "$python $pyscript a b c";
  exec("$cmd", $output);
  print($output[0]);


  $pyscript = './siam2nite.py';
  $url = 'https://www.siam2nite.com/en/pictures/onyx-presents-aquafest-2017-at-onyx-18859';
  $cmd = "scrapy runspider $pyscript -a url=$url -o test.csv";
  exec("$cmd", $output);
  print($output[0]);
  */
?>
