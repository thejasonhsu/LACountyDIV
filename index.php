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
		case 'confirm':
			confirm();
		case 'submit':
			submit();
		default:
			landingpage();
	}

	function login() {
		// Check for valid AIN and PIN match
		$validMatch = true;
		$captchaResponse = true;

		if ($validMatch && $captchaResponse) {
			// Get info from database

			form();
		}
		else {
			// Show that it was an invalid combination
		}
	}

	function logout() {
		unset( $_SESSION['username'] );
		// Is there a formal logout? Where do we redirect them?
	}

	function form() {
		require( TEMPLATE_PATH . "form.html" );
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