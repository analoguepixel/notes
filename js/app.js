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
  // called every 5 seconds after edit and by save button
  function save() {
    if(id) 
    {
      var payload = {'note':  $textBox.html().trim(), 
                     'title': $titleBox.text().trim(), 
                     'id':     id};
    }
    else
    {
      var payload = {'note':  $textBox.html().trim(), 
                     'title': $titleBox.text().trim(), 
                     'id':     id};
    }

    $.ajax({
      type: "POST",
      url: "../add/",
      data: payload,
      cache: false,
      success: function(data){
        data = JSON.parse(data);
        console.log(data);
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

  function insertTab() {
    
  }

  var timeout = setTimeout;
  function autoSave() {
    if(timeout)
      clearTimeout(timeout);
    timeout = setTimeout(save, 2500);
    $status.text('editing');
  }

  $textBox.on("input", autoSave); 

  $saveBtn.on('click', save);

  $deleteBtn.on('click', del);
});
