<?php
require_once('db_setup.php');
$link = db_default_connection();
db_setup_connections_table($link);
echo "<div id = 'picker'>
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
				echo "<h1>$text</h1>
				<ul>
					<li><a href = '#' id = '$data[choice1]'>Retry</a></li>
				</ul>
				";
			}
			else{
				if ($result[1] == '(ORANGE)'){
					$text = substr($data['text'], strlen($result[0])+strlen($result[1])+1);
					echo "<h1>$text</h1>
					<ul>
						<li><a href = '#' id = '000001'>Play Again</a></li>
					</ul>
					";
				}
				else{
					$text = substr($data['text'], strlen($result[0])+1);
					echo "<h1>$text</h1>
					<ul>
						<li><a href = '#' id = '000001'>Play Again</a></li>
					</ul>
					";
				}
			}
		}
		else if ($data['nextPrompt'] != '000000'){
			echo "<h1>$data[text]</h1>
			<ul id = '$data[id]'>
				<li><a href='#' id = '" . $data['nextPrompt'] . "'>Continue</a></li>
			</ul>
			";
		}
		else{
			$sql1 = mysql_query("SELECT promptID, text FROM choices WHERE id = '" . $data['choice1'] . "'");
			$choice1 = mysql_fetch_array($sql1);
			if (!$choice1){
				$choice1_text = '';
				$choice1_id = '';
			}
			else{
				$choice1_text = $choice1['text'];
				$choice1_id = $choice1['promptID'];
			}
			$sql2 = mysql_query("SELECT promptID, text FROM choices WHERE id = '" . $data['choice2'] . "'");
			$choice2 = mysql_fetch_array($sql2);
			if (!$choice2){
				$choice2_text = '';
				$choice2_id = '';
			}
			else{
				$choice2_text = $choice2['text'];
				$choice2_id = $choice2['promptID'];
			}
			$sql3 = mysql_query("SELECT promptID, text FROM choices WHERE id = '" . $data['choice3'] . "'");
			$choice3 = mysql_fetch_array($sql3);
			if (!$choice3){
				$choice3_text = '';
				$choice3_id = '';
			}
			else{
				$choice3_text = $choice3['text'];
				$choice3_id = $choice3['promptID'];
			}
			echo "<h1>$data[text]</h1>
			<ul>
			";
				if ($choice1_text != ''){
					echo "<li><a href = '#' id = '$choice1_id'>$choice1_text</a></li>
					";
				}
				if ($choice2_text != ''){
					echo "<li><a href = '#' id = '$choice2_id'>$choice2_text</a></li>
					";
				}
				if ($choice3_text != ''){
					echo "<li><a href = '#' id = '$choice3_id'>$choice3_text</a></li>
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
?>