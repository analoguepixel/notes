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


});
