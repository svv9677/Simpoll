<?
	if(strpos($_SERVER['REQUEST_URI'], "index.php") == false)
	{
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('view.php', 'index.php', $_SERVER['REQUEST_URI']);
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		exit();
	}

	// take corresponding action
	if ($RESPOND == "CREATE")
	{
		connect_db();
		$query = "INSERT INTO poll_info VALUES (null, '" . $_GET["date"] . "', 1, " . $_GET["show_id"] . ", "
												. $_GET["show_vote"] . ", " . $_GET["select_multiple"] . ", '" . $_GET["question"] . "', '"
												. $_GET["choice1"] . "', '" . $_GET["choice2"] . "', '"
												. $_GET["choice3"] . "', '" . $_GET["choice4"] . "', '"
												. $_GET["choice5"] . "', '" . $_GET["choice6"] . "', '"
												. $_GET["choice7"] . "', '" . $_GET["choice8"] . "', '"
												. $_GET["choice9"] . "', '" . $_GET["choice10"] . "')";
		$result = mysql_query($query);	
		if ($result == false) {
			echo "<h3>Unable to create poll. Error: " . mysql_error() . "</h3>";
		} else {
			$new_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			echo '<script type="text/javascript">
				bootbox.alert("Poll created successfully.", function() {
						window.top.location="' . $new_uri . '";
				});</script>';
		}
		
		mysql_close();
	}
	else if ($RESPOND == "CLOSE")
	{
		connect_db();
		$id = $_GET["id"];
		
		$query = "UPDATE poll_info SET status=0 WHERE id = " . $id;
		$result = mysql_query($query);	
		mysql_close();
		if ($result == false) {
			echo "<h3>Unable to close poll. Error: " . mysql_error() . "</h3>";
		} else {
			$new_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			echo '<script type="text/javascript">
				bootbox.alert("Poll is now closed.<br>You can view the results of the poll by clicking its link on the home page.", function() {
						window.top.location="' . $new_uri . '";
				});</script>';
		}
	}
	else if ($RESPOND == "DELETE")
	{
		connect_db();
		$id = $_GET["id"];

		$query1 = "DELETE FROM poll_info WHERE id = " . $id;
		$result1 = mysql_query($query1);	
		$query2 = "DELETE FROM poll_data WHERE id = " . $id;
		$result2 = mysql_query($query2);	
		mysql_close();

		if ($result1 == false || $result2 == false) {
			echo "<h3>Unable to delete poll. Error: " . mysql_error() . "</h3>";
		} else {
			$new_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			echo '<script type="text/javascript">
				bootbox.alert("Poll has been deleted.", function() {
						window.top.location="' . $new_uri . '";
				});</script>';
		}				
	}
	else if ($RESPOND == "CLEAR_VOTE")
	{
		connect_db();
		$id = $_GET["id"];
		$query = "DELETE FROM poll_data WHERE id = " . $id . " AND user_id = '" . $USER_EMAIL . "'";
		//echo $query;
		$result = mysql_query($query);	

		if ($result == false) {
			echo "<h3>Unable to delete your poll vote. Error: " . mysql_error() . "</h3>";
		} else {
			$new_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?command=VIEW&id=' . $id;
			echo '<script type="text/javascript"> window.top.location="' . $new_uri . '"; </script>';
		}				
		mysql_close();
	}
	else if ($RESPOND == "VOTE")
	{
		if ($_GET["vote_type"] == "radio")
		{
			for ($i = 1; $i <= 10; $i++)
			{
				$key = "choice" . $i;
				if ($_GET["answer"] == $key)
					$data[$key] = 1;
				else
					$data[$key] = 0;
			}
		} else if ($_GET["vote_type"] == "checkbox")
		{
			for ($i = 1; $i <= 10; $i++)
			{
				$key = "choice" . $i;
				if (isSet($_GET[$key]))
					$data[$key] = $_GET[$key];
				else
					$data[$key] = 0;
			}
		}
		
		connect_db();
		if ($_GET["vote"] == "VOTE")
		{
			$query = "INSERT INTO poll_data VALUES (" . $_GET["id"] . ", '" . $USER_EMAIL . "', '" 
													. $user . "', '" . date("Y-m-d H:i:s") . "', "
													. $data["choice1"] . ", " . $data["choice2"] . ", "
													. $data["choice3"] . ", " . $data["choice4"] . ", "
													. $data["choice5"] . ", " . $data["choice6"] . ", "
													. $data["choice7"] . ", " . $data["choice8"] . ", "
													. $data["choice9"] . ", " . $data["choice10"] . ")";
			$result = mysql_query($query);	
			//echo $query;
			if ($result == false) {
				die("Unable to cast vote. Error: " . mysql_error());
			}
		} 
		else if ($_GET["vote"] == "UPDATE")
		{
			$query = "UPDATE poll_data SET vote_time = '" . date("Y-m-d H:i:s") . "', choice1 = " . $data["choice1"] . ", choice2 = " . $data["choice2"] . ", choice3 = "
													. $data["choice3"] . ", choice4 = " . $data["choice4"] . ", choice5 = "
													. $data["choice5"] . ", choice6 = " . $data["choice6"] . ", choice7 = "
													. $data["choice7"] . ", choice8 = " . $data["choice8"] . ", choice9 = "
													. $data["choice9"] . ", choice10 = " . $data["choice10"] . " WHERE id = " . $_GET["id"] . " AND user_id = '" . $USER_EMAIL . "'";
			$result = mysql_query($query);	
			//echo $query;
			if ($result == false) {
				die("Unable to update vote. Error: " . mysql_error());
			}
		}
		
		mysql_close();
		echo '<script type="text/javascript">window.top.location = "./index.php?command=VIEW&id=' . $_GET["id"] . '";</script>';
	}
	
?>