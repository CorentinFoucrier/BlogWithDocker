$( document ).ready(function() {
  // globals
    var searchInput;
    var textDiv;

    $('#submit').click(function(event) {

    $('span').contents().unwrap();

    event.preventDefault();
    // set the values of the search and the text
    searchInput = $('#search').val();
    textDiv = $('article').html();
    var pattern = '('+searchInput+')(?![^<]*>)';
    var reg = new RegExp(pattern, 'gi');
    var txt = textDiv.replace(reg, function(str) {
        return "<span class='highlight'>" + str + "</span>"
    });
    $( 'article' ).html(txt);
    });
});