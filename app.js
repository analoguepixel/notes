$(function() {
  var $searchBox = $('#search');
  var noteList = [];

  function getList() {
    var refund = new Array();
    $.ajax({
      type: "GET",
      url: "list.php",
      cache: false,
      async: "false",
      success: function(data) {
        noteList = JSON.parse(data);
        Object.freeze(noteList);
        showList(noteList);
      }
    });
  }

  function showList(list) {
    $noteList = $('#noteList');
    var liStr = '';
    function listItem(id, title, body, date) {
      return '<li><a href="note?id=' + id + '">' +
             '<span class="note-title">' +
             title + 
             '</span><br>' + 
             '<span class="note-summary">' +
             ( (body.length < 45) ?
               body : 
               body.substr(0, 45) + '. . .') + 
             '</span><br>' + 
             '<span class="date">' +
             date + 
             '</span></a>' + '</li>';
    }

    var len = list.length;
    for(var i = 0; i < len; i++) {
      liStr += listItem(list[i].id, list[i].title, list[i].body, list[i].date);
    }
    $noteList.html(liStr);
  }

  function search(terms, list) {
    // TODO: add support or multiple search terms
    var matchList = [];
    var len = list.length;
    var exp = new RegExp( terms, 'gi');
    for(var i = 0; i < len; i++) {
      note = list[i];
    console.log(note);

      var titleMatch = note.title.search(exp);
      var bodyMatch  = note.body.search(exp);
      if(titleMatch != -1) {
        matchList.push(note);
      }
      else if(bodyMatch != -1) {
        var tempNote = {};
        note.body = note.body.substr(bodyMatch, bodyMatch + 45);
        matchList.push(note);
      }
    }
    return matchList;
  }
  $searchBox.on('input', function() {
    var terms = $searchBox.val();
    var notes = noteList; 
    if(terms === '')
      showList(noteList);
    else
    showList( search(terms, notes) );
  });


  getList();

});
