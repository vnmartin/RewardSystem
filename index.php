<?php
$select9 = mysql_query("SELECT * FROM rewards WHERE name='$row[name]'");
$count9 = mysql_num_rows($select9);
?>

<?php
if($count9==0) {
	echo " ";
}
else {
	echo "<h2>Rewards</h2>";
	echo "<center>....</center>";
	echo "<table class=\"table table-striped\">\n";
	echo "<tr><td width=\"33%\"><b>Name</b></td><td width=\"33%\"><b>For</b></td><td width=\"33%\" align=center><b>Rewards</b></td></tr>\n";
	while($row9=mysql_fetch_assoc($select9)) {
		echo "<tr><td>$row9[name]</td><td>$row9[what]</td><td align=center>";
		echo "<a href=rewards.php?id=$row9[id]>Claim</a>";
		echo "</td></tr>\n";
	}
	echo "</table>\n";
}
?>
