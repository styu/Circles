$(document).ready(function(){
	var init = 1;
	//initial game state
	id = getID(init, 6);
	$.post('php/choose.php', {promptID: id}, function(data) {
		var div = $(data);
			$(data).appendTo('#main_content').fadeIn(1000);
		var poem = unescape($('#poem_hidden').text());
	
	$('#poem').append("<p>"+poem+"</p>");
	$('#poem_hidden').remove();
	});
	
	$('li a').live('click', function(){
		var id = $(this).attr('id');
		$.post('php/choose.php', {promptID:id}, function(data) {
			$('#picker').fadeOut().remove();
			var div = $(data);
			$(data).appendTo('#main_content').fadeIn();
			var poem = unescape($('#poem_hidden').text());
			if ($('#picker ul').attr('id') == '000001'){
				$('#poem').empty();
				$('#poem').append("<p>"+poem+"</p>").fadeIn();
			}
			else{
				$('#poem').append("<p>"+poem+"</p>");
			}
			$('#poem_hidden').remove();
		});
		
	});
});

function getID(num, count){
	var initString = ""+num;
	while (initString.length < count){
		initString = "0" + initString;
	}
	return initString;
}

