<?php
	ob_start();
	set_include_path(get_include_path() . PATH_SEPARATOR . './google-api-php-client/src');
	require_once('Google/autoload.php');

	$client_id = '448890997617-26ia8ichemi79g6hf5kfk0hi0vnj709k.apps.googleusercontent.com';
	$client_secret = 'kAbaP0jLV9rkttr7b2jVjLfN';
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	
	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->setScopes(array('email','profile'));
	$plus = new Google_Service_Oauth2($client);

	if (isset($_REQUEST['logout']) && isset($_COOKIE['access_token'])) {
		setcookie('access_token', '', time()-3600);
		echo '<script type="text/javascript"> window.top.location="' . $redirect_uri . '";</script>';
		ob_end_flush();
		exit();
	}

	if (isset($_GET['code']) && !isset($_COOKIE['access_token'])) {
		$client->authenticate($_GET['code']);
		setcookie('access_token', $client->getAccessToken(), time()+(86400*30));
		echo '<script type="text/javascript"> window.top.location="' . $_SERVER['PHP_SELF'] . '";</script>';
		ob_end_flush();
		exit();
	}

	try {
		if (isset($_COOKIE['access_token']) && $_COOKIE['access_token']) {
			$client->setAccessToken($_COOKIE['access_token']);
		} else {
			$authUrl = $client->createAuthUrl();
		}

		if ($client->getAccessToken()) {
			setcookie('access_token', $client->getAccessToken(), time()+(86400*30));
			$token_data = $client->verifyIdToken()->getAttributes();
			$user_info = $plus->userinfo->get();
		}
	} catch(Exception $e) {
		setcookie('access_token', '', time()-3600);
		echo '<script type="text/javascript"> window.top.location="' . $redirect_uri . '";</script>';
		ob_end_flush();
		exit();
	}

	if (strpos($client_id, "googleusercontent") == false) {
		echo missingClientSecretsWarning();
		setcookie('access_token', '', time()-3600);
		echo '<script type="text/javascript"> window.top.location="' . $redirect_uri . '";</script>';
		ob_end_flush();
		exit();
	}

	if (isset($authUrl)) {
		$user = null;
		$USER_EMAIL = "";
		//echo "<a class='login' href='" . $authUrl . "'><img src='https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png'></img></a>";
	} else {
		$user = $user_info['name'];
		$USER_EMAIL = $user_info['email'];
		//echo "<a class='logout' href='?logout'>Logout as " . $user_info['familyName'] . " <img width='20' height='20' src='" . $user_info['picture'] . "'></img></a>";
	}

	/*echo '<div class="data">';

	if (isset($token_data)) {
		var_dump($token_data);
	}

	echo "<br><br><br>";

	if(isset($user_info)) {
		print_r($user_info);
	}

	echo '</div>';*/

	/*
	array(2) { 
		["envelope"]=> 
			array(2) { 
				["alg"]=> string(5) "RS256" 
				["kid"]=> string(40) "81c054c7a65c046d51b72777bda95c7cb1c2e8eb" 
			} 
		["payload"]=> 
			array(9) { 
				["iss"]=> string(19) "accounts.google.com" 
				["at_hash"]=> string(22) "xIlAv3YJ0NbVmgzRsyuwtg" 
				["aud"]=> string(72) "448890997617-26ia8ichemi79g6hf5kfk0hi0vnj709k.apps.googleusercontent.com" 
				["sub"]=> string(21) "105904021455415809315" 
				["email_verified"]=> bool(true) 
				["azp"]=> string(72) "448890997617-26ia8ichemi79g6hf5kfk0hi0vnj709k.apps.googleusercontent.com" 
				["email"]=> string(28) "subbarao.vadapalli@gmail.com" 
				["iat"]=> int(1457728017) 
				["exp"]=> int(1457731617) 
			}
		} 

	Google_Service_Oauth2_Userinfoplus Object 
	( 
		[internal_gapi_mappings:protected] => 
			Array ( 
				[familyName] => family_name 
				[givenName] => given_name 
				[verifiedEmail] => verified_email ) 
		[email] => subbarao.vadapalli@gmail.com 
		[familyName] => Vadapalli 
		[gender] => male 
		[givenName] => Subbarao 
		[hd] => 
		[id] => 105904021455415809315 
		[link] => https://plus.google.com/105904021455415809315 
		[locale] => en-GB 
		[name] => Subbarao Vadapalli 
		[picture] => https://lh4.googleusercontent.com/-MBGEFD6Cqz8/AAAAAAAAAAI/AAAAAAAAAAA/ryQUyA44hh8/photo.jpg 
		[verifiedEmail] => 1 
		[modelData:protected] => Array ( [verified_email] => 1 [given_name] => Subbarao [family_name] => Vadapalli ) [processed:protected] => Array ( ) )
	*/
	ob_end_flush();
?>