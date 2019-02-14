<?php include('header.php');

if(!$_SERVER['QUERY_STRING']) {
$select = mysql_query("SELECT * FROM rewards ORDER BY id ASC");
?>
<script type="text/javascript" language="JavaScript">
function confirmAction(){
      var confirmed = confirm("Are you sure? This will remove this entry forever.");
      return confirmed;
}
</script>
<h2>Reward Member</h2>
	<form method="post" action="reward.php?added">
	<table class="table table-striped">
		<tr><td colspan=3>
	<textarea class="form-control" name="name" rows="5" cols="80" placeholder="Names"><?php
$select_bday = mysql_query("SELECT * FROM `$table_members` WHERE status='Active' ORDER BY `name` ASC");
$names = array();
while($row = mysqli_fetch_array($select_bday)) {
 $names[] = $row['name'];
}
echo implode(', ', $names);
?></textarea>
</td></tr>
	<tr>
	<td><input type="text" name="what" placeholder="What the reward is for" /></td>
	<td><input type="text" name="regchoice" placeholder="Regular Choice" /></td>
	<td><input type="text" name="regran" placeholder="Regular Random" /></td></tr>
	<tr><td><input type="text" name="spchoice" placeholder="Special Choice" /></td>
	<td><input type="text" name="spran" placeholder="Special Random" /></td>
	<td><button type="submit" name="submit">Add!</button></td></tr>
	</table>
	</form>

<h2>Rewards</h2>
<?php
	echo "<table class=\"table table-striped\"\n";
	echo "<tr><td width=\"25%\"><b>Name</b></td><td width=\"65%\"><b>Reward for</b></td><td width=5%><b>Delete</b></td></tr>\n";
	while($row=mysql_fetch_assoc($select)) {
		echo "<tr><td>$row[name]</td><td><b>" . $row[date] . ":</b> $row[what]</td><td align=center><a href=reward.php?delete=$row[id] onclick=\"return confirmAction()\"><div style=\"color: red;\">&#x2716;</div></a></td></tr>\n";
	}
	echo "</table>\n";

?>
	<?php
}

elseif($_SERVER['QUERY_STRING']=="added") {
	if (!isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] != "POST") {
	    exit("<p>You did not press the submit button; this page should not be accessed directly.</p>");
	}
	else {
	    $exploits = "/(content-type|bcc:|cc:|document.cookie|onclick|onload|javascript|alert)/i";
	    $profanity = "/(beastial|bestial|blowjob|clit|cum|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuck|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|kock|kondum|kum|kunilingus|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
	    $spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|blackjack|backgammon|texas|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
	    $bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer)/i";
	    if (preg_match($bots, $_SERVER['HTTP_USER_AGENT'])) {
	        exit("<h1>Error</h1>\nKnown spam bots are not allowed.");
	    }
	    foreach ($_POST as $key => $value) {
	        $value = trim($value);
	        if (empty($_POST['name'])) {
	            exit("<h1>Error</h1>\nAll fields are required. Please go back and complete the form.");
	        }
	        elseif (preg_match($exploits, $value)) {
	            exit("<h1>Error</h1>\nExploits/malicious scripting attributes aren't allowed.");
	        }
	        elseif (preg_match($profanity, $value) || preg_match($spamwords, $value)) {
	            exit("<h1>Error</h1>\nThat kind of language is not allowed through this form.");
	        }
	        $_POST[$key] = stripslashes(strip_tags($value));
	    }
	    	$name = htmlspecialchars(strip_tags($_POST['name']));
	    	$what = htmlspecialchars(strip_tags($_POST['what']));
	    	$regchoice = htmlspecialchars(strip_tags($_POST['regchoice']));
	    	$regran = htmlspecialchars(strip_tags($_POST['regran']));
	    	$spchoice = htmlspecialchars(strip_tags($_POST['spchoice']));
	    	$spran = htmlspecialchars(strip_tags($_POST['spran']));
	    	$date = date("Y-m-d");
	$array = explode(', ',$name);
	$array_count = count($array);
	for($i=0; $i<=($array_count -1); $i++) {

			$insert = "INSERT INTO rewards (`id`, `name`, `what`, `regchoice`, `regran`, `spchoice`, `spran`, `date`) VALUES ('', '$array[$i]', '$what', '$regchoice', '$regran', '$spchoice', '$spran', '$date')";
			mysql_query($insert, $connect);

	}

?>
    <META HTTP-EQUIV="Refresh" Content="0; URL=reward.php">
<?php
	}
}
if($id = !$_GET['delete']) {}
else {
	$delete = $_GET['delete'];
	$delete2 = "DELETE FROM `rewards` WHERE id='$delete'";
	if(mysql_query($delete2, $connect)){
		echo "<h1>Deleted</h1>";
		echo "<center><i>Reward has been deleted.</i></center>";
	}
	else {
		echo "<h1>Error</h1>";
		echo "<center><i>Reward has not been deleted.</i></center>";
	}
}
include('footer.php'); ?>
