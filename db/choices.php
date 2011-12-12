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
	$sql = mysql_query("SELECT * FROM choices") or print ('derp');
	echo "<table>
			<tr>
			<th>id</th>
			<th>text</th>
			<th>promptID</th>
			<th>character</th>
			<th>distance</th>
			<th>size</th>
			</tr>";
	while ($row = mysql_fetch_array($sql)){
		echo "<tr>
			<td>$row[id]</td>
			<td>$row[text]</td>
			<td>$row[promptID]</td>
			<td>$row[character]</td>
			<td>$row[distance]</td>
			<td>$row[size]</td>
			</tr>";
	}
	echo "</table>";
	?>
</body>
</head>