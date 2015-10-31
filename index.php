<?php
	require( "config.php" );

	session_start();
	$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

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

		// Check captcha response
		$captcha = false;
		if ( isset( $_POST['g-recaptcha-response'] ) ) {
			$captcha = $_POST['g-recaptcha-response'];
		}
		if ( !$captcha ) {
			// Error: User did not respond to captcha

			// DEBUG
			echo "Captcha not entered. ";
			exit;
		}

		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		$response = json_decode($response);

		if($response->success == false) {
			// Error: Captcha was not successful

			// DEBUG
			echo "Unsucessful; not a human. ";
			exit;
		}
		else {
			// DEBUG
			echo "Captcha response was a success. ";
		}

		// Check that valid AIN and PIN were given
		$validMatch = false;
		$ain; $pin;

		if ( isset( $_POST['AIN'] ) && isset( $_POST['PIN'] ) ) {

				$ain = $_POST['AIN'];
				$pin = $_POST['PIN'];

				// DEBUG
				echo '<p></p>';
				echo "AIN: " . $ain . " " . "PIN: " . $pin;

				// TODO: Pass ain and pin to rest service

				// DEBUG
				$validMatch = true;				
		}
		else {
			// Error: User did not enter both an AIN and PIN
			echo "Please enter both AIN and PIN. ";
		}

		if ($validMatch && $response->success) {
			// DEBUG
			echo '<p></p>';
			echo "Valid match and successful captcha response. ";

			form();
		}
		else {
			// Error: Show that it was an invalid combination
		}
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