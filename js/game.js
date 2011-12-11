$(document).ready(function(){
	function Game(){
		this.name = 'test';
		this.getName = getName;
		
		function getName(){
			$('#test').text(this.name);
		}
	}

	
});

