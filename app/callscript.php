<script>
  function runSpider() {
    $.ajax({
      type: "POST",
      url: "spider.php",
      data: { pyFunction: "runSiam2nite",
              url: document.getElementById('urlSiam2nite').value,
            }
      }).done(function( msg ) {
        //  alert( "Data Saved: " + msg );
          alert( msg );
      });
    }

    function saveFace($uid, $tid) {
      $.ajax({
        type: "POST",
        url: "spider.php",
        data: { pyFunction: "saveFace",
                uid: $uid,
                tid: $tid,
              }
        }).done(function( msg ) {
          //  alert( "Data Saved: " + msg );
            alert( msg );
        });
    }

    function trainFirstTime() {
      $.ajax({
        type: "POST",
        url: "spider.php",
        data: { pyFunction: "trainFirstTime",
                uid: document.getElementById('uid').value,
                tid: document.getElementById('tid').value,
              }
        }).done(function( msg ) {
          //  alert( "Data Saved: " + msg );
            alert( msg );
        });
    }
    function predictSiam2nite() {
      $.ajax({
        type: "POST",
        url: "spider.php",
        data: { pyFunction: "predictSiam2nite",
                uid: document.getElementById('uid').value,
                tid: document.getElementById('tid').value,
                url: document.getElementById('urlSiam2nite').value,
              }
        }).done(function( msg ) {
          //  alert( "Data Saved: " + msg );
            alert( msg );
        });
    }
    </script>
