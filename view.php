<?
	if(strpos($_SERVER['REQUEST_URI'], "index.php") == false)
	{
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('view.php', 'index.php', $_SERVER['REQUEST_URI']);
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		exit();
	}

	connect_db();
	
	$ID = $_GET["id"];
	
	$query="SELECT * FROM poll_info WHERE id=" . $ID;
	$result = mysql_query($query);	
	if ($result == false)
	{
		die("Failed to get poll information!! " . mysql_error());
	}
	$record = array();
	$record["id"] = $ID;
	$record["date"] = mysql_result($result, 0, "date");
	$record["question"] = mysql_result($result, 0, "question");
	$record["status"] = mysql_result($result, 0, "status");
	$record["show_id"] = mysql_result($result, 0, "show_id");
	$record["show_vote"] = mysql_result($result, 0, "show_vote");
	$record["select_multiple"] = mysql_result($result, 0, "select_multiple");
	
	$record["choice1"] = mysql_result($result, 0, "choice1");
	$record["choice2"] = mysql_result($result, 0, "choice2");
	$record["choice3"] = mysql_result($result, 0, "choice3");
	$record["choice4"] = mysql_result($result, 0, "choice4");
	$record["choice5"] = mysql_result($result, 0, "choice5");
	$record["choice6"] = mysql_result($result, 0, "choice6");
	$record["choice7"] = mysql_result($result, 0, "choice7");
	$record["choice8"] = mysql_result($result, 0, "choice8");
	$record["choice9"] = mysql_result($result, 0, "choice9");
	$record["choice10"] = mysql_result($result, 0, "choice10");

	$query = "SELECT * FROM poll_data WHERE id = " . $ID . " AND user_id = '" . $USER_EMAIL . "'";
	//echo $query;
	$result = mysql_query($query);	
	if ($result == false)
	{
		die("Failed to get poll data!! " . mysql_error());
	}
	$num = mysql_numrows($result);
	if ($num == 0)
	{
		$vote_exists = false;
		$submit_key = "VOTE";

		$user_input = array();
		$user_input["choice1"] = 0;
		$user_input["choice2"] = 0;
		$user_input["choice3"] = 0;
		$user_input["choice4"] = 0;
		$user_input["choice5"] = 0;
		$user_input["choice6"] = 0;
		$user_input["choice7"] = 0;
		$user_input["choice8"] = 0;
		$user_input["choice9"] = 0;
		$user_input["choice10"] = 0;
	}
	else
	{
		$vote_exists = true;
		$submit_key = "UPDATE";
	
		$user_input = array();
		$user_input["choice1"] = mysql_result($result, 0, "choice1");
		$user_input["choice2"] = mysql_result($result, 0, "choice2");
		$user_input["choice3"] = mysql_result($result, 0, "choice3");
		$user_input["choice4"] = mysql_result($result, 0, "choice4");
		$user_input["choice5"] = mysql_result($result, 0, "choice5");
		$user_input["choice6"] = mysql_result($result, 0, "choice6");
		$user_input["choice7"] = mysql_result($result, 0, "choice7");
		$user_input["choice8"] = mysql_result($result, 0, "choice8");
		$user_input["choice9"] = mysql_result($result, 0, "choice9");
		$user_input["choice10"] = mysql_result($result, 0, "choice10");
	}
	
	if ($record["select_multiple"] == 1)
		$option_type_string = "checkbox";
	else
		$option_type_string = "radio";
	
	if ($record["status"] == 0)
		$closed_poll_string = "disabled";
	else
		$closed_poll_string = "";
	////////////////////////////////////////////////////////////////////////////////////////////////
?>
	
	<script>
	function checkvote()
	{
		var x = document.forms["theViewForm"]["answer"].value;
		if(x == null || x == "")
		{
			if ($option_type_string == "radio")
				alert("Please select your choice");
			else
				alert("Please select at least one choice");
			return false;
		}
		return true;
	}
	</script>

	<h2><u>Question</u></h2>
	<h3><? echo $record["question"]; ?></h3>
	<h4 style="padding: 10px;">Created: <? echo date('l jS \of F Y h:i:s A', strtotime($record['date']) ); ?>
	<form name="theViewForm" target="_top" onSubmit="return checkvote()" action="./index.php?#" method="get">
	<input name="respond" type="hidden" value="VOTE" />
	<input name="vote_type" type="hidden" value="<? echo $option_type_string; ?>" />
	<input name="id" type="hidden" value="<? echo $ID; ?>" />

<?
	for ($i = 1; $i <= 10; $i++)
	{
		$key = "choice" . $i;
		if ($record[$key] != null) {
			if ($record[$key] != "") {
				if ($option_type_string == "radio")
				{
					echo '<input type="radio" name="answer" value="' . $key;
					if ($user_input[$key] == 1)
						echo '" checked ' . $closed_poll_string;
					else
						echo '"' . $closed_poll_string;
					echo '> ' . $record[$key] . '<br/>';
				}
				else if ($option_type_string == "checkbox")
				{
					echo '<input type="checkbox" name="' . $key . '" value="1"';
					if ($user_input[$key] == 1)
						echo ' checked ' . $closed_poll_string;
					else
						echo $closed_poll_string;
					echo '> ' . $record[$key] . '<br/>';
				}
			}
		}
	}

	if ($record["status"] == 1)
	{
		if ($vote_exists)
		{
			echo '<p style="margin:0px; padding:2px">Your vote is shown above. You can change your vote until the poll is closed. </p>';
			echo '<p style="color:red; margin:0px; padding:2px">Do not forget to press the UPDATE button to update your vote! </p>';
		}
		else
			echo '<p style="color:red; margin:0px">Do not forget to press the VOTE button to submit your vote! </p>';

		echo '<input type="submit" name="vote" value="' . $submit_key . '" />';
	}
	else
		echo '<label>This poll is closed.</label>';

	echo '</form>';

	if ($vote_exists)
	{
		echo '<form name="theClearForm" target="_top" action="./index.php?#" method="get"> <input name="respond" type="hidden" value="CLEAR_VOTE"/>
			  <input name="id" type="hidden" value="' . $ID . '" /> <input type="submit" name="vote" value="CLEAR" /></form></h4>';
	}
	else
		echo '</h4>';


	$show_id = $record["show_id"];
	$show_vote = $record["show_vote"];
	global $IS_ADMIN;
	
	if ($IS_ADMIN)
	{
		$show_id = 1;
		$show_vote = 1;
	}

	$query = "SELECT * FROM poll_data WHERE id=" . $ID . " ORDER BY user_name ASC";
	$result = mysql_query($query);	
	if ($result == false)
	{
		die("Failed to get poll data!! " . mysql_error());
	}
	$num = mysql_numrows($result);

	$data = array();
	for($i=0; $i < $num; $i++)
	{
		$data[$i] = mysql_fetch_array($result, MYSQL_ASSOC);
	}
	
	if ($show_vote == 1)
	{
		$display_data = array();
		
		for ($i = 1; $i <= 10; $i++)
		{
			$key = "choice" . $i;
			if ($record[$key] != null) 
			{
				if ($record[$key] != "") 
				{
					$cnt = 0;
					$voters = array();
					$voter_ids = array();
					$voter_time = array();
					for ($j = 0; $j < $num; $j++)
					{
						if ($data[$j][$key] == 1)
						{
							$voters[$cnt] = $data[$j]["user_name"];
							$voter_ids[$cnt] = $data[$j]["user_id"];
							$voter_time[$cnt] = date('l F jS Y h:i:s A', strtotime($data[$j]["vote_time"]) );
							$cnt ++;
						}
					}
					
					$display_data[$key]["count"] = $cnt;
					$display_data[$key]["voters"] = $voters;
					$display_data[$key]["voter_ids"] = $voter_ids;
					$display_data[$key]["voter_time"] = $voter_time;
				}
			}
		}
		
		if ($num == 1)
			echo '<h2>Responses: 1 person cast his/her vote.</h2><h3>';
		else
			echo '<h2>Responses: ' . $num . ' people cast their vote.</h2><h3>';
		for ($i = 1; $i <= 10; $i++)
		{
			$key = "choice" . $i;
			if ($record[$key] != null) 
			{
				if ($record[$key] != "") 
				{
					echo $record[$key] . ' : ' . $display_data[$key]["count"] . '<br/>';
					if ($show_id == 1)
					{
						$names_list = "";
						echo '<table style="width:100%; font-size:12px" class="sortable">';
						echo '<tr><th>Name</th><th>Email</th><th>Date last voted</th></tr>';
						for($t = 0; $t < $display_data[$key]["count"]; $t++)
						{
							$name = ucwords(strtolower($display_data[$key]["voters"][$t]));
							$names_list = $names_list . $name . "\n";
							echo '<tr><td>' . $name .  '</td><td>' . strtolower($display_data[$key]["voter_ids"][$t]) . '</td><td>' . $display_data[$key]["voter_time"][$t] . '</td></tr>';
						}
						echo '</table>';

						echo '<button height="20px" class="copy-button" data-clipboard-text="' . $names_list . '"><img src="images/clippy.svg" width="25px" height="20px" alt="Copy to clipboard">Copy to Clipboard</button><br><br>';
					}
				}
			}
		}
		echo '</h3>';
	}
	mysql_close();

	echo "<script> (function(){ new Clipboard('.copy-button'); })();</script>";