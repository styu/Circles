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
td{
	border:1px solid #000000;
}
</style>
</head>
<body>
<?php
	$sql = mysql_query("SELECT * FROM prompts") or print ('derp');
	echo "<table>
			<tr>
			<th>id</th>
			<th>text</th>
			<th>poem</th>
			<th>choice 1</th>
			<th>choice 2</th>
			<th>choice 3 </th>
			<th>[op] next prompt</th>
			</tr>";
	while ($row = mysql_fetch_array($sql)){
		echo "<tr>
			<td>$row[id]</td>
			<td>$row[text]</td>
			<td>$row[poem]</td>
			<td>$row[choice1]</td>
			<td>$row[choice2]</td>
			<td>$row[choice3]</td>
			<td>$row[nextPrompt]</td>
			</tr>";
	}
	echo "</table>";
	?>
</body>
</head>