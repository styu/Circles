<?php
require_once('db_setup.php');
$link = db_default_connection();
db_setup_connections_table($link);
echo "<div id = 'picker'>
<h1>It's your turn:</h1>
";
if (!empty($_POST['promptID'])){
	$sql = mysql_query("SELECT * FROM prompts WHERE id = '" . $_POST['promptID'] . "'");
	$data = mysql_fetch_array($sql);
	if (!$data){
		echo "<h1>Herp derp a cow, records in your SQL database are missing</h1>";
	}
	else{
		if ($data['nextPrompt'] == '999999'){
			$result = explode(" ", $data['text']);
			if ($result[0] == '(ALONE)' || $result[0] == '(END)'){
				$text = substr($data['text'], strlen($result[0])+1);
				echo "<h2>$text</h2>
				<ul id = '999999'>
					<li><a href = '#' id = '$data[choice1]'>Retry</a></li>
				</ul>
				";
			}
			else{
				if ($result[1] == '(ORANGE)'){
					$text = substr($data['text'], strlen($result[0])+strlen($result[1])+1);
					$index = getColor($result[0]);
					echo "<h2>$text</h2>
					<ul id = '000001' name = '$index'>
						<li><a href = '#' id = '000001'>Play Again</a></li>
					</ul>
					";
				}
				else{
					$text = substr($data['text'], strlen($result[0])+1);
					$index = getColor($result[0]);
					echo "<h2>$text</h2>
					<ul id = '000001' name = '$index'>
						<li><a href = '#' id = '000001'>Play Again</a></li>
					</ul>
					";
				}
			}
		}
		else if ($data['nextPrompt'] != '000000'){
			echo "<h2>$data[text]</h2>
			<ul id = '$data[id]'>
				<li><a href='#' id = '" . $data['nextPrompt'] . "'>Continue</a></li>
			</ul>
			";
		}
		else{
			$sql1 = mysql_query("SELECT * FROM choices WHERE id = '" . $data['choice1'] . "'");
			$choice1 = mysql_fetch_array($sql1);
			if (!$choice1){
				$choice1_text = '';
				$choice1_id = '';
			}
			else{
				$choice1_text = $choice1['text'];
				$choice1_id = $choice1['promptID'];
				$choice1_char = $choice1['character'];
				$choice1_param = $choice1['distance'] . ' ' . $choice1['size'];
			}
			$sql2 = mysql_query("SELECT * FROM choices WHERE id = '" . $data['choice2'] . "'");
			$choice2 = mysql_fetch_array($sql2);
			if (!$choice2){
				$choice2_text = '';
				$choice2_id = '';
			}
			else{
				$choice2_text = $choice2['text'];
				$choice2_id = $choice2['promptID'];
				$choice2_char = $choice2['character'];
				$choice2_param = $choice2['distance'] . ' ' . $choice2['size'];
			}
			$sql3 = mysql_query("SELECT * FROM choices WHERE id = '" . $data['choice3'] . "'");
			$choice3 = mysql_fetch_array($sql3);
			if (!$choice3){
				$choice3_text = '';
				$choice3_id = '';
			}
			else{
				$choice3_text = $choice3['text'];
				$choice3_id = $choice3['promptID'];
				$choice3_char = $choice3['character'];
				$choice3_param = $choice3['distance'] . ' ' . $choice3['size'];
			}
			echo "<h2>$data[text]</h2>
			<ul id = '$data[id]'>
			";
				if ($choice1_text != ''){
					echo "<li><a href = '#' id = '$choice1_id' name = '$choice1_char' rel = '$choice1_param'>$choice1_text</a></li>
					";
				}
				if ($choice2_text != ''){
					echo "<li><a href = '#' id = '$choice2_id' name = '$choice2_char' rel = '$choice2_param'>$choice2_text</a></li>
					";
				}
				if ($choice3_text != ''){
					echo "<li><a href = '#' id = '$choice3_id' name = '$choice3_char' rel = '$choice3_param'>$choice3_text</a></li>
					";
				}
			echo "</ul>
			";
		}
		//$poem = urlencode($data['poem']);
		$poem = $data['poem'];
		echo "<div id = 'poem_hidden'>$poem</div>
		";
	}
}
echo "</div>";

function getColor($color){
	if ($color == '(BLACK)'){
		return 1;
	}
	else if ($color == '(BLUE)'){
		return 2;
	}
	else if ($color == '(GREEN)'){
		return 3;
	}
	else if ($color == '(RED)'){
		return 4;
	}
	else if ($color == '(ORANGE)'){
		return 5;
	}
	else if ($color == '(PINK)'){
		return 6;
	}
}
mysql_close($link);
?>