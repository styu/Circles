$(document).ready(function(){
	var init = 1;
	var count = 1;
	var left_shift = [-1, 1, -1, 1, -1, 1];
	var top_shift = [0, 0, 1, 1, -1, -1];
	var left = 10;
	var top = 17;
	//initial game state
	id = getID(init, 6);
	$.post('php/choose.php', {promptID: id}, function(data) {
		var div = $(data);
			$(data).appendTo('#main_content').fadeIn(1000);
		var poem = unescape($('#poem_hidden').text());
	
	$('#poem').append("<p id = '" + init + "'>"+poem+"<br /></p>");
	$('#poem_hidden').remove();
	});
	
	$('li a').live('click', function(){
		var id = $(this).attr('id');
		var previous = $('#picker ul').attr('id');
		var character = $(this).attr('name');
		var attributes = $(this).attr('rel').split(" ");
		//moving the circles
		if (character != 0){
			var circle = ".c" + character;
			var orig_left = $(".c0").css('left');
			var orig_top = $(".c0").css('top');
			var circle_left = $(circle).css('left');
			var circle_top = $(circle).css('top');
			var newLeft = parseInt(attributes[0])*left_shift[character-1]*left;
			if (Math.abs(parseInt(circle_left.substring(0, circle_left.length-2))+newLeft-parseInt(orig_left.substring(0, orig_left.length-2))) <= 46){
				newLeft = 0;
				newTop = 0;
			}
			var newTop = parseInt(attributes[0])*top_shift[character-1]*top;
			if (Math.abs(parseInt(circle_top.substring(0, circle_top.length-2)) + newTop - parseInt(orig_top.substring(0, orig_top.length-2))) <= 46){
				newTop = 0;
			}

			var radiusChange = 1 + 0.2*parseInt(attributes[1]);
			var circle_radius = $(circle).css('height');
			var new_radius = Math.round(parseInt(circle_radius.substring(0, circle_radius.length-2))*radiusChange);
			if (new_radius <= 10){
				new_radius = 10;
			}
			$(circle).animate({
				left: '+='+newLeft,
				top: '+='+newTop,
				height: new_radius+'px',
				width: new_radius+'px',
				borderTopLeftRadius: new_radius, 
			    borderTopRightRadius: new_radius, 
			    borderBottomLeftRadius: new_radius, 
			    borderBottomRightRadius: new_radius,
			    WebkitBorderTopLeftRadius: new_radius, 
			    WebkitBorderTopRightRadius: new_radius, 
			    WebkitBorderBottomLeftRadius: new_radius, 
			    WebkitBorderBottomRightRadius: new_radius, 
			    MozBorderRadius: new_radius 
			}, 500);
		}
		//updating to next prompt and set of choices
		$.post('php/choose.php', {promptID:id}, function(data) {
			$('#picker').fadeOut().remove();
			var div = $(data);
			$(data).appendTo('#main_content').fadeIn();
			var poem = unescape($('#poem_hidden').text());
			if (previous == '000001'){
				$('#poem').empty();
				$('#poem').append("<p id = '1'>"+poem+"<br /></p>").fadeIn();
				init = 1;
				count = 1;
			}
			else{
				if (count < 4){
					$('#'+init).append(poem+"<br />");
					count ++;
				}
				else{
					init ++;
					count = 1;
					$('#poem').append("<p id = '" + init + "'>"+poem+"<br /></p>");
				}
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

