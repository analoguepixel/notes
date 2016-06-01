$(function() {
  function getList() {
    var refund = new Array();
    $.ajax({
      type: "GET",
      url: "list.php",
      cache: false,
      async: "false",
      success: function(data) {
        showList(JSON.parse(data));
      },
      // add failure function
      failure: function(data) {

      }
    });
  }

  function showList(list) {
    $noteList = $('#noteList');
    var liStr = '';
    function listItem(id,title, date) {
      return '<li><a href="note?id=' + id + '">' +
             '<span class="note-title">' +
             title + 
             '</span><br>' + 
             '<span class="date">' +
             date + 
             '</span></a>' + '</li>';
    }
    var len = list.length;
    for(var i = 0; i < len; i++) {
      liStr += listItem(list[i].id, list[i].title, list[i].date);
    }
    $noteList.html(liStr);
  }
  getList();

  function showNote(note) {

    var payload = {'note':  note.note,
                   'uid':     id};

    $.ajax({
      type: "POST",
      url: "/api/note/",
      cache: false,
      async: "false",
      data: payload,
      success: function(data) {
        (JSON.parse(data));
      }
    });
  }
  var note = {"id": id, "note": 148};
  $('#testbutton').click(showNote(note));


});
