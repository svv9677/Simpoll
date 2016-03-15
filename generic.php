<?
	if(strpos($_SERVER['REQUEST_URI'], "index.php") == false)
	{
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('generic.php', 'index.php', $_SERVER['REQUEST_URI']);
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		exit();
	}

	connect_db();
	global $IS_ADMIN;
	
	// sorted latest first
	$query="SELECT id, status, question FROM poll_info ORDER BY date DESC, id DESC";
	$result = mysql_query($query);
	$num = 0;
	$polls = array($num);	
	if($result != false)
	{
		$num = mysql_numrows($result);
		$polls = array($num);
		$i=0;
		while ($i < $num) {
			$record = array();
			$record["id"] = mysql_result($result, $i, "id");
			$record["question"] = mysql_result($result, $i, "question");
			$record["status"] = mysql_result($result, $i, "status");
			$polls[$i] = $record;
			$i++;
		}
	}

	echo '<table> <tr><th colspan="3">ACTIVE POLLS</th></tr>';
	$found = false;
	for ($i = 0; $i < $num; $i++)
	{
		$poll = $polls[$i];
		// if active poll
		if ($poll["status"] == 1)
		{
			$found = true;
			echo '<tr><td><a target="_top" href="';
			echo "./index.php?command=VIEW&id=";
			echo $poll["id"] . '">' . $poll["question"] . '</a></td>';
			if ($IS_ADMIN) {
			?>
				<td><a onclick="return confirm('Sure?')" target="_top" href="<? echo "./index.php?respond=CLOSE&id=" . $poll["id"]; ?>">CLOSE POLL</a></td> 
				<td><a onclick="return confirm('Sure?')" target="_top" href="<? echo "./index.php?respond=DELETE&id=" . $poll["id"]; ?>">DELETE POLL</a></td>
			<?}
			echo '</tr>';
		}
	}
	if ($found == false)
		echo '<tr><td>No active polls present at the moment. Please check back later.</td></tr>';
	echo '</table>';

	echo '<table> <tr><th colspan="3">CLOSED POLLS</th></tr>';
	$found = false;
	for ($i = 0; $i < $num; $i++)
	{
		$poll = $polls[$i];
		// if active poll
		if ($poll["status"] == 0)
		{
			$found = true;
			echo '<tr><td><a target="_top" href="';
			echo "./index.php?command=VIEW&id=";
			echo $poll["id"] . '">' . $poll["question"] . '</a></td>';
			if ($IS_ADMIN) {
			?>
				<td><a onclick="return confirm('Sure?')" target="_top" href="<? echo "./index.php?respond=DELETE&id=" . $poll["id"]; ?>">DELETE POLL</a></td>
			<?}
			echo '</tr>';
		}
	}
	if ($found == false)
		echo '<tr><td>No closed polls..</td></tr>';
	echo '</table>';
	
	mysql_close();

?>