<?
	include './backend.php';

 	$local_hosts = array('localhost', '127.0.0.1');
	$MYSQL_URL = "localhost";
	if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $local_hosts)) 
	{
		$MYSQL_URL = "svv9677.dot5hostingmysql.com";
	}

	$IS_ADMIN = false;
	if($USER_EMAIL == "subbarao.vadapalli@gmail.com" || 
		$USER_EMAIL == "bipshin4u@gmail.com" ||
		$USER_EMAIL == "faisal.qadir1@gmail.com")
	{
		$IS_ADMIN = true;
	}

	date_default_timezone_set('America/Los_Angeles');

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="js/bootstrap.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>    
	<script src="js/bootbox.min.js"></script>
	<script src="js/sorttable.js"></script>
	<script src="js/clipboard.min.js"></script>
</head>

<body>