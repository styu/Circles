$(document).ready(function(){
	var init = 1;
	//initial game state
	id = getID(init, 6);
	$.post('php/choose.php', {promptID: id}, function(data) {
		$('#picker').empty().append(data);
	});
	$('li a').live('click', function(){
		var id = $(this).attr('id');
		$.post('php/choose.php', {promptID:id}, function(data) {
			$('#picker').empty();
			var newData = $(data);
			$('#picker').empty();
			newData.appendTo($('#picker')).fadeIn();
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

