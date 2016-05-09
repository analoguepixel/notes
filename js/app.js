"use strict";
$(function() {
  var $titleBox  = $('#title');
  var $textBox   = $('#text');
  var $saveBtn   = $('#save');
  var $deleteBtn = $('#delete');
  var $status    = $('#noteStatus');

  // save function
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

        // if an id is returned, set window.id to the new id
        if(data.id && data.id > 0)
        {
          id = data.id;
        }
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

  // autosave function
  var timeout = setTimeout;
  var delay   = 1250;
  function autoSave() {
    if(timeout)
      clearTimeout(timeout);
    timeout = setTimeout(save, delay);
    $status.text('editing');
  }

  $textBox.on("input", autoSave); 

  $saveBtn.on('click', save);

  $deleteBtn.on('click', del);
});
