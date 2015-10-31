<?php
	require( "config.php" );

	session_start();
	$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

	echo $action;

	switch ( $action ) {
		case 'login':
			login();
			break;
		case 'form':
			form();
			break;
		case 'confirm':
			confirm();
			break;
		case 'submit':
			submit();
			break;
		default:
			landingpage();
	}

	function login() {
		// Check for valid AIN and PIN match
		
		form();

		/*$validMatch = true;

		// Check captcha response
		$captcha
		if ( isset( $_POST['g-recaptcha-response'] ) ) {
			$captcha = $_POST['g-recaptcha-response'];
		}
		if ( !$captcha ) {
			// Show error; they did not respond to captcha
			exit;
		}

		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=YOUR SECRET KEY&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		if($response.success==false) {
			// Show error; 
		}
		else
		{
			echo '<h2>Thanks for posting comment.</h2>';
		}

		if ($validMatch && $response) {
			// Get info from database

			form();
		}
		else {
			// Show that it was an invalid combination
		}*/
	}

	function logout() {
		unset( $_SESSION['username'] );
		// Is there a formal logout? Where do we redirect them?
	}

	function form() {
		require( TEMPLATE_PATH . "appform.html" );
	}

	function confirm() {

	}

	function submit() {
		
	}

	function landingpage() {
		require( TEMPLATE_PATH . "landing.html" );
	}

	/*$array = PropertyInfo::getInfoUsingId(2023007025);
	print_r($array);
	echo "The AIN for the record requested is: ";
	echo $array['AIN'];*/
?>