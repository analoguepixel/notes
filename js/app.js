"use strict";
$(function() {
  var $titleBox  = $('#title');
  var $textBox   = $('#text');
  var $saveBtn   = $('#save');
  var $deleteBtn = $('#delete');
  var $status    = $('#noteStatus');

  // font selection buttons
  var $fontBtns = {
    "sans":  $('#fntSans'),
    "serif": $('#fntSerif'),
    "mono":  $('#fntMono')
  }

  var fonts = [
    {'font': 'sans',  'button': $fontBtns.sans},
    {'font': 'serif', 'button': $fontBtns.serif},
    {'font': 'mono',  'button': $fontBtns.mono}
  ];

  //var selectedFont;
  window.selectedFont = '';

  // save function
  function save() {
    if(id) 
    {
      var payload = {'note':  $textBox.html().trim(), 
                     'title': $titleBox.text().trim(), 
                     'font':  window.selectedFont,
                     'id':     id};
    }
    else
    {
      var payload = {'note':  $textBox.html().trim(), 
                     'title': $titleBox.text().trim(), 
                     'font':  window.selectedFont,
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

  // change font function
  function changeFont(font) {
   return function() {
     // change font classes
     $textBox.removeClass('sans serif mono').addClass(font);
     $('.font-select.active').removeClass('active');
     $('.font-select.' + font).addClass('active');

     // change font settings for document
     window.selectedFont = font;
     save();
   }
  }

  $textBox.on("input", autoSave); 

  $saveBtn.on('click', save);

  $deleteBtn.on('click', del);

  // apply event handlers for selecting fonts
  // TODO: loop
  var len = fonts.length;
  for( var i = 0; i < len; i++) {
    var font = fonts[i];
    font.button.click( changeFont(font.font) );
  }

});
