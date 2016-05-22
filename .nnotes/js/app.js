"use strict";
$(function() {
  var $titleBox  = $('#title');
  var $textBox   = $('#text');
  var $saveBtn   = $('#save');
  var $deleteBtn = $('#delete');
  var $status    = $('#noteStatus');

  console.log($textBox);
  console.log($saveBtn);

  // save function
  // called every 15 seconds after change
  function save() {
    if(id) 
    {
      var payload = {'note':  $textBox.html().trim(), 
                     'title': $titleBox.html().trim(), 
                     'id':     id};
    }
    else
    {
      var payload = {'note':  $textBox.html().trim(), 
                     'title': $titleBox.html().trim(), 
                     'id':     id};
    }

    $.ajax({
      type: "POST",
      url: "../add/",
      data: payload,
      cache: false,
      success: function(data){
        console.log(data);
        if(data.status)
          $status.text(data.status);
      }
    });
  }
  
  // delete function
  function del() { 
    var payload = {'id': id};

    $.ajax({
      type: "POST",
      url: "../delete/",
      data: payload,
      cache: false,
      success: function(data){
        data = JSON.parse(data);
        console.log(data);
        if(data.status=='success')
          window.location.href="../";
      }
    });
  }

  $saveBtn.on('click', save);

  $deleteBtn.on('click', del);
});
