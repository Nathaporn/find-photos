<?php
function helloPython() {
  $.ajax({
    type: "POST",
    url: "spider.php",
    data: { pyFunction: "helloPython",
            uid: document.getElementById('uid').value,
            tid: document.getElementById('tid').value,
          }
    }).done(function( msg ) {
      //  alert( "Data Saved: " + msg );
        alert( msg );
    });
  }

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

    function saveFace() {
      $.ajax({
        type: "POST",
        url: "spider.php",
        data: { pyFunction: "saveFace",
                uid: document.getElementById('uid').value,
                tid: document.getElementById('tid').value,
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
 ?>
