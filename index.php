<?
	include './header.php';
	
	if ($user != null)
	{
		$COMMAND = isset($_GET["command"]) ? $_GET["command"] : null;
		$RESPOND = isset($_GET["respond"]) ? $_GET["respond"] : null;
		
		echo '<div id="wrap">';
		echo '<div id="header-photo">';
		echo '<h1 id="logo-text"><a target="_top" href="./index.php" title="">Westwood Polls</a></h1>';
		echo '<h2 id="slogan">be proactive... it only takes a few minutes to vote</h2>';
		echo '</div>';
		
		echo '<div id="nav"><ul>';
		echo '<li><a target="_top" href="./index.php?#">Home</a></li>';
		if($IS_ADMIN)
			echo '<li><a target="_top" href="./index.php?command=CREATE">Create Poll</a></li>';
		echo '<li><a target="_blank" href="http://www.facebook.com/groups/westwood.united/">Visit The Group</a></li>';
		echo '<li><a target="_top" href="./index.php?logout">Logout ' . $user_info['familyName'] . '  <img width="30" height="30" src="' . $user_info['picture'] . '"></img></a></li>';
		echo '</ul></div>';
		
		echo '<div id="content-wrap"><div id="main">';

		/////////////////////////////////////////////////////////////////////////////////////////////////
		// we need to respond to a submitted query
		if ($RESPOND != null)
		{
			include './response.php';
		}
		// we need to display options for user action
		else 
		{
			if ($COMMAND == null ) {
				include './generic.php';
			} else if ($COMMAND == "GENERIC") {
				include './generic.php';
			} else if ($COMMAND == "CREATE") {
				include './create.php';
			} else if ($COMMAND == "VIEW") {
				include './view.php';
			}
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////
		
		echo '</div></div>';
		echo '<div id="footer-wrap"><div id="footer"><p>Maintained and hosted at Subbarao-Vadapalli.info</p></div></div>';
		echo '</div>';
	}
	else
	{
		echo '<div id="wrap">';
		echo '<div id="header-photo">';
		echo '<h1 id="logo-text"><a target="_top" href="./index.php" title="">Westwood Polls</a></h1>';
		echo '<h2 id="slogan">be proactive... it only takes a few minutes to vote</h2>';
		echo '</div>';
		
		echo '<div id="nav"><ul>';
		echo '<li><a target="_top" href="' . $authUrl . '"><img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"></img></a></li>';
		echo '</ul></div>';
		
		echo '<div id="content-wrap"><div id="main">';

	}
?>

</body>
</html>
