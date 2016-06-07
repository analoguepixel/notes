"use strict";
$(function() {
  var $titleBox   = $('#title');
  var $textBox    = $('#text');
  var $titleField = $('#title');
  var $saveBtn    = $('#save');
  var $deleteBtn  = $('#delete');
  var $status     = $('#noteStatus');
  var $newGuest   = $('#new-guest');
  var $guestList  = $('#guest-list');

  // font selection buttons
  var $fontBtns = {
    "sans":  $('#fntSans'),
    "serif": $('#fntSerif'),
    "mono":  $('#fntMono'),
    "hand":  $('#fntHand')
  }

  var fonts = [
    {'font': 'sans',  'button': $fontBtns.sans},
    {'font': 'serif', 'button': $fontBtns.serif},
    {'font': 'mono',  'button': $fontBtns.mono},
    {'font': 'hand',  'button': $fontBtns.hand}
  ];

  //var selectedFont;
  window.selectedFont = '';

  // save function
  function save() {
    if(id) 
    {
      var payload = {'note':  $textBox.val().trim(), 
                     'title': $titleBox.text().trim(), 
                     'font':  window.selectedFont,
                     'id':     id};
    }
    else
    {
      var payload = {'note':  $textBox.val().trim(), 
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
     $textBox.removeClass('sans serif mono hand').addClass(font);
     $('.font-select.active').removeClass('active');
     $('.font-select.' + font).addClass('active');

     // change font settings for document
     window.selectedFont = font;
     save();
   }
  }
  
  // addGuest function
  function addGuest() {
    var guestName = $newGuest.val();
    $newGuest.val('');
    var newGuestEntry = document.createElement('li');
    newGuestEntry.innerHTML = guestName;
    newGuestEntry.id = 'guest-' + guestName;
    newGuestEntry.className = 'inactive';
    var $newGuestEntry = $(newGuestEntry);
    $newGuest.parent('li').before($newGuestEntry);

    // ajax
    var payload = {'note':  id,
                   'guest': guestName};
    $.ajax({
      type: "POST",
      url: "../sharing/",
      data: payload,
      cache: false,
      success: function(data){
        //data = JSON.parse(data);
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

  // removeGuest function
  function removeGuest($guest) {
    $guest.remove();
  }


  $textBox.on("input", autoSave); 
  
  $titleField.on("input", autoSave); 

  $newGuest.keyup( function(e) {
    console.log(e.which);
    if((e.which === 32 || e.which === 13) &&
        $newGuest.val() !== '' ) {
      addGuest();
    }
    else if (e.which == 8) {
      if($newGuest.val() == '')
      {
        removeGuest($newGuest.parent('li').prev());
      }
    }
  });

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
