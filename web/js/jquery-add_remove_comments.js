function remove_comment(link) {
    $(this).parent().remove();
    		
    updateNames();
    return false;
}
    	
function add_comment() {
	added = $('<li><textarea rows="4" cols="30"></textarea><br /><a href="#">Diesen Kommentar entfernen.</a></li>');
	added.appendTo('#comments');
	$('a', added).click(remove_comment);

    updateNames();
    return false;
}

function updateNames() {
    var elements = $('#comments > li > textarea');
    for(i = 0; i<elements.size(); i++) {
    	elements[i].name = "residents[comments]["+i+"][comment]";
    }
}
    	
$(document).ready(function () {
$('#comments > li > a').click(remove_comment);
$('#addComment').click(add_comment);
});

