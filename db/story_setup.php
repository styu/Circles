<html>
<head>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/game.js"></script>
<?php
require_once('../php/db_setup.php');
$link = db_default_connection();
//db_setup($link);
db_setup_connections_table($link);
//db_insert_prompts();
//db_insert_choices();
?>
<style>
.text{
	width: 500px;
}
.texttext{
	display:inline-block;
}
.label{
	width:150px;
	display:inline-block;
}
a{
	text-decoration:none;
}
</style>
</head>
<body>
<?php
if (!empty($_GET['prompt'])){
	$promptID = $_GET['prompt'];
}	
else{
	$promptID = '000001';
}
if (!empty($_POST)){
	$SQL_UPDATE = "UPDATE prompts SET ";
		
	if (!empty($_POST['text']) && $_POST['text'] != ''){
		$SQL_UPDATE .= "text='" . addslashes(urldecode($_POST['text']))."', ";
	}
	if (!empty($_POST['poem']) && $_POST['poem'] != ''){
		$SQL_UPDATE .= "poem='" . addslashes(urldecode($_POST['poem']))."', ";
	}
	if (!empty($_POST['choice1']) && $_POST['choice1'] != ''){
		$SQL_UPDATE .= "choice1='".$_POST['choice1']."', ";
	}
	if (!empty($_POST['choice2']) && $_POST['choice2'] != ''){
		$SQL_UPDATE .= "choice2='".$_POST['choice2']."', ";
	}
	if (!empty($_POST['choice3']) && $_POST['choice3'] != ''){
		$SQL_UPDATE .= "choice3='".$_POST['choice3']."', ";
	}
	if (!empty($_POST['nextPrompt']) && $_POST['nextPrompt'] != ''){
		$SQL_UPDATE .= "nextPrompt='".$_POST['nextPrompt']."', ";
	}
	$SQL_UPDATE = trim($SQL_UPDATE, ", ") . " WHERE id = '$promptID'";
	mysql_query($SQL_UPDATE) or print ("error " . mysql_error());
	
	if (!empty($_POST['choice1_prompt']) && $_POST['choice1_prompt'] != ''){
		mysql_query("UPDATE choices SET promptID = '".$_POST['choice1_prompt']."' WHERE id = '" . $_POST['choice1'] . "'") or print ("error: " . mysql_error());
	}
	if (!empty($_POST['choice2_prompt']) && $_POST['choice2_prompt'] != ''){
		mysql_query("UPDATE choices SET promptID = '".$_POST['choice2_prompt']."' WHERE id = '" . $_POST['choice2'] . "'") or print ("error: " . mysql_error());
	}
	if (!empty($_POST['choice3_prompt']) && $_POST['choice3_prompt'] != ''){
		mysql_query("UPDATE choices SET promptID = '".$_POST['choice3_prompt']."' WHERE id = '" . $_POST['choice3'] . "'") or print ("error: " . mysql_error());
	}
}
$formURL = 'story_setup.php?prompt=' . $promptID;
$sql = mysql_query("SELECT * FROM prompts WHERE id = '$promptID'");
$promptData = mysql_fetch_array($sql);

if ($promptData['nextPrompt'] != '000000'){
	$nextPrompthref = 'story_setup.php?prompt=' . $promptData['nextPrompt'];
	$nextsql = mysql_query("SELECT text FROM prompts WHERE id = '" . $promptData['nextPrompt'] . "'");
	$nextdata = mysql_fetch_array($nextsql);
	$nextPromptText = $nextdata['text'];
}
else{
	$nextPrompthref = '#';
	$nextPromptText = '';
}
$choice1sql = mysql_query("SELECT * FROM choices WHERE id = '$promptData[choice1]'");
$choice1data = mysql_fetch_array($choice1sql);
if (!$choice1data){
	$choice1href = '#';
	$choice1prompt = '000000';
	$choice1text = ' ';
}
else{
	$choice1href = 'story_setup.php?prompt=' . $choice1data['promptID'];
	$choice1prompt = $choice1data['promptID'];
	$choice1text = $choice1data['text'];
}
$choice2sql = mysql_query("SELECT * FROM choices WHERE id = '$promptData[choice2]'");
$choice2data = mysql_fetch_array($choice2sql);
if (!$choice2sql){
	$choice2href = '#';
	$choice2prompt = '000000';
	$choice2text = '';
}
else{
	$choice2href = 'story_setup.php?prompt=' . $choice2data['promptID'];
	$choice2prompt = $choice2data['promptID'];
	$choice2text = $choice2data['text'];
}
$choice3sql = mysql_query("SELECT * FROM choices WHERE id = '$promptData[choice3]'");
$choice3data = mysql_fetch_array($choice3sql);
if (!$choice3sql){
	$choice3href = '#';
	$choice3prompt = '000000';
	$choice2text = '';
}
else{
	$choice3href = 'story_setup.php?prompt=' . $choice3data['promptID'];
	$choice3prompt = $choice3data['promptID'];
	$choice3text = $choice3data['text'];
}
$text = urlencode($promptData['text']);
$poem = urlencode($promptData['poem']);
echo "<form action = '$formURL' method = 'post'>
		<div class = 'label'><b>id: </b></div> $promptData[id] <br />
		<div class = 'label'><b>text: </b></div><div class = 'texttext'> $promptData[text]</div><br />
		<div class = 'label'><b>text: </b></div><input class = 'text' type = 'text' value = '$text' name = 'text' /><br />
		<div class = 'label'><b>poem: </b></div><input class = 'text' type = 'text' value = '$poem' name = 'poem' /><br />
		<div class = 'label'><b>choice 1: </b></div><div class = 'texttext'> $choice1text</div><br />
		<div class = 'label'><b>choice 1: </b></div><input type = 'text' value = '$promptData[choice1]' name = 'choice1' maxlength = '6' /><br />
		<div class = 'label'><a href = '$choice1href'>choice 1 prompt: </a></div><input type = 'text' value = '$choice1prompt' maxlength = '6' name = 'choice1_prompt' /><br />
		<div class = 'label'><b>choice 2: </b></div><div class = 'texttext'> $choice2text</div><br />
		<div class = 'label'><b>choice 2: </b></div><input type = 'text' value = '$promptData[choice2]' name = 'choice2' maxlength = '6' /><br />
		<div class = 'label'><a href = '$choice2href'>choice 2 prompt: </a></div><input type = 'text' value = '$choice2prompt' maxlength = '6' name = 'choice2_prompt' /><br />
		<div class = 'label'><b>choice 3: </b></div><div class = 'texttext'> $choice3text</div><br />
		<div class = 'label'><b>choice 3: </b></div><input type = 'text' value = '$promptData[choice3]' name = 'choice3' maxlength = '6' /><br />
		<div class = 'label'><a href = '$choice3href'>choice 3 prompt: </a></div><input type = 'text' value = '$choice3prompt' maxlength = '6' name = 'choice3_prompt' /><br />
		<div class = 'label'><b>[or] skip to next prompt: </b></div><div class = 'texttext'>$nextPromptText</div><br />
		<div class = 'label'><a href = '$nextPrompthref'>next prompt: </a></div><input type = 'text' value = '$promptData[nextPrompt]' name = 'nextPrompt' maxlength = '6' /><br />
		<input type = 'submit' value = 'Save changes' />
	</form>";
?>
</body>
</head>