<?php session_start();if (isset($_SESSION['USR_LOGIN'])=="") {	header("Location: /login.php");}
include(".../mytcg/settings.php");include("$header");

if(!$_SERVER['QUERY_STRING']) {
	?>
	<b>Error!</b> This page shouldn't be accessed directly! Please go back and try something else.
	<?php
}
else {
	$id=$_GET['id'];
	$getdata = mysql_query("SELECT * FROM rewards WHERE id='$id'");
	$check = mysql_fetch_array($getdata);

	$getdata2 = mysql_query("SELECT * FROM members WHERE id='" .$_SESSION[USER_ID]. "'");
	$check2 = mysql_fetch_array($getdata2);

if ($check[name] == $check2[name]) {
	$select = mysql_query("SELECT * FROM rewards WHERE id='$id'");
	while ($row=mysql_fetch_assoc($select)) {
		$name = $row[name];
		$what = $row[what];
		$regchoice = $row[regchoice];
		$regran = $row[regran];
		$spchoice = $row[spchoice];
		$spran = $row[spran];
		mysql_query("DELETE FROM rewards WHERE id='$id'");

?>
<h1><?php echo $what; ?></h1>
<center><?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<$regran; $i++) {
mysql_data_seek($result, rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$card = "$row[filename]$_digits";
echo "<img src=\"$tcgcardurl/$card.png\" border=\"0\" /> ";
$rewards .= $card.", ";
}
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='2'");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<$spran; $i++) {
mysql_data_seek($result, rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$card = "$row[filename]$_digits";
echo "<img src=\"$tcgcardurl/$card.png\" border=\"0\" /> ";
$rewards .= $card.", ";
}
{
$rewards = substr_replace($rewards,"",-2);

echo "<br /><b>$what:</b> ";
if ($regchoice == 1) {
	echo $regchoice;
	echo " regular choice card, ";
}
elseif ($regchoice > 1) {
	echo $regchoice;
	echo " regular choice cards, ";
}
else {

}
if ($spchoice == 1) {
	echo $spchoice;
	echo " special choice card, ";
}
elseif ($spchoice > 1) {
	echo $spchoice;
	echo " special choice cards, ";
}
else {

}
if ($regran > 0 || $spran > 0) {
	echo $rewards;
}
else {

}
}
?></center>
<?php }
}
else {
	?>
	<b>Error!</b> This is not your reward.
	<?php
}
}
include("$footer"); ?>
