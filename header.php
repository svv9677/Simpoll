<?
	include './backend.php';

 	$local_hosts = array('localhost', '127.0.0.1');
	$MYSQL_URL = "localhost";
	if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $local_hosts)) 
	{
		$MYSQL_URL = "svv9677.dot5hostingmysql.com";
	}

	$IS_ADMIN = false;
	if($USER_EMAIL == "subbarao.vadapalli@gmail.com")
	{
		$IS_ADMIN = true;
	}

	function connect_db()
	{
		global $MYSQL_URL;
		$link = mysql_connect($MYSQL_URL, 'poll_user', 'poll_pass'); 
		if (!$link) { 
			die('Could not connect: ' . mysql_error()); 
		} 
		//echo 'Connected successfully'; 
		@mysql_select_db(westwood) or die( "Unable to select database" . mysql_error());
	}
	
	function send_mail($from, $to, $subject, $body)
	{
		$headers = 'From: ' . $from;
		$body = wordwrap($body, 70);
		if (mail($to, $subject, $body, $headers)) {
			return true;
		} else {
			return false;
		}
	}
	
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
	<title>Westwood Cricket Club - Polls</title>
	<link rel="stylesheet" href="images/MarketPlace.css" type="text/css" />
</head>

<body>