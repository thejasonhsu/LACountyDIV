<?php
	require( "resources/config.php" );

	session_start();
	$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

	if ( $action != "login" && $action != "logout" && !$username ) {
	  landingpage();
	  exit;
	}

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
		case 'edit':
			edit();
			break;
		case 'logout':
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

		$response = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'] );
		$response = json_decode( $response );

		if( $response->success == false ) {
			// Error: Captcha was not successful

			// DEBUG
			echo "Unsucessful; not a human. ";
			require( TEMPLATE_PATH . "landing.php" );
		}
		else {
			// DEBUG
			echo "Captcha response was a success. ";
		}

		// Check that valid AIN and PIN were given
		$loginError = NULL;
		$validMatch = false;
		$ain; $pin; $ainWithDashes;

		if ( isset( $_POST['AIN'] ) && isset( $_POST['PIN'] ) ) {

				$ain = $_POST['AIN'];
				$pin = $_POST['PIN'];

				$ainWithDashes = $ain;

				// DEBUG
				echo '<p></p>';
				echo "AIN with Dashes: " . $ainWithDashes;

				// Remove dashes from AIN
				$ain = str_replace( "-", "", $ain );

				// DEBUG
				echo '<p></p>';
				echo "AIN: " . $ain . " " . "PIN: " . $pin;

				// Pass ain and pin to rest service
				$loginData = json_encode( array( 'ain' => $ain,'pin' => $pin ), JSON_FORCE_OBJECT );
				$restResult = Rest::restValidate( $loginData );

				if ( strcmp( $restResult, "success" ) == 0 ) {
					// DEBUG
					echo '<p></p>';
					echo "Valid ain/pin match!";
					
					$validMatch = true;
				}
				else {
					// DEBUG
					echo '<p></p>';
					echo "Invalid ain/pin match!";
					
					$validMatch = false;
					$loginError = true;
					require( TEMPLATE_PATH . "landing.php" );
				}
		}
		else {
			// Error: User did not enter both an AIN and PIN
			echo '<p></p>';
			echo "Please enter both AIN and PIN. ";
			$loginError = true;
			require( TEMPLATE_PATH . "landing.php" );
		}

		if ( $validMatch && $response->success ) {
			// DEBUG
			echo '<p></p>';
			echo "Valid match and successful captcha response. AIN: " . $ain;

			$loginError = false;

			$_SESSION['username'] = $ainWithDashes;

			form($ain, $ainWithDashes); // Question: Should we make appform the default and use header instead of require when they sign in?
		}
		else {
			// DEBUG
			echo '<p></p>';
			echo "Error: Invalid ain/pin pair";

			// Error: Show that it was an invalid combination
			$loginError = true;
			require( TEMPLATE_PATH . "landing.php" );
		}
	}

	function logout() {
		unset( $_SESSION['username'] );
		header( "Location: index.php" );
	}

	function form($ain, $ainWithDashes) {
		$propInfo = new PropertyInfo( $ain );
		$dbResults = $propInfo->getInfo( $ain );

		require( TEMPLATE_PATH . "appform.php" );
	}

	function confirm() {
		$userResponse = array();
		$userResponse['ownerName'] = isset( $_POST['OwnerName'] ) ? $_POST['OwnerName'] : "";
		$userResponse['telephone'] = isset( $_POST['Telephone'] ) ? $_POST['Telephone'] : "";
		$userResponse['email'] = isset( $_POST['Email'] ) ? $_POST['Email'] : "";
		$userResponse['confirmEmail'] = isset( $_POST['ConfirmEmail'] ) ? $_POST['ConfirmEmail'] : "";
		$userResponse['opinionOfValue'] = isset( $_POST['OpinionOfValue'] ) ? $_POST['OpinionOfValue'] : "";
		$userResponse['propertyType'] = isset( $_POST['PropertyType'] ) ? $_POST['PropertyType'] : "";
		$userResponse['approxSqFootage'] = isset( $_POST['ApproxSqFootage'] ) ? $_POST['ApproxSqFootage'] : "";
		$userResponse['numBedrooms'] = isset( $_POST['NumBedrooms'] ) ? $_POST['NumBedrooms'] : "";
		$userResponse['numBathrooms'] = isset( $_POST['NumBathrooms'] ) ? $_POST['NumBathrooms'] : "";
		$userResponse['comp1Address'] = isset( $_POST['Comp1Address'] ) ? $_POST['Comp1Address'] : "";
		$userResponse['comp1City'] = isset( $_POST['Comp1City'] ) ? $_POST['Comp1City'] : "";
		$userResponse['comp1Zip'] = isset( $_POST['Comp1Zip'] ) ? $_POST['Comp1Zip'] : "";
		$userResponse['comp1AIN'] = isset( $_POST['Comp1AIN'] ) ? $_POST['Comp1AIN'] : "";
		$userResponse['comp1SaleDate'] = isset( $_POST['Comp1SaleDate'] ) ? $_POST['Comp1SaleDate'] : "";
		$userResponse['comp1SalePrice'] = isset( $_POST['Comp1SalePrice'] ) ? $_POST['Comp1SalePrice'] : "";
		$userResponse['comp1Description'] = isset( $_POST['Comp1Description'] ) ? $_POST['Comp1Description'] : "";
		$userResponse['comp2Address'] = isset( $_POST['Comp2Address'] ) ? $_POST['Comp2Address'] : "";
		$userResponse['comp2City'] = isset( $_POST['Comp2City'] ) ? $_POST['Comp2City'] : "";
		$userResponse['comp2Zip'] = isset( $_POST['Comp2Zip'] ) ? $_POST['Comp2Zip'] : "";
		$userResponse['comp2AIN'] = isset( $_POST['Comp2AIN'] ) ? $_POST['Comp2AIN'] : "";
		$userResponse['comp2SaleDate'] = isset( $_POST['Comp2SaleDate'] ) ? $_POST['Comp2SaleDate'] : "";
		$userResponse['comp2Description'] = isset( $_POST['Comp2Description'] ) ? $_POST['Comp2Description'] : "";
		$userResponse['comp2SalePrice'] = isset( $_POST['Comp2SalePrice'] ) ? $_POST['Comp2SalePrice'] : "";
		$userResponse['additionalInfo'] = isset( $_POST['AdditionalInformation'] ) ? $_POST['AdditionalInformation'] : "";

		// Get info for form that was from the database
		$ain = str_replace( "-", "", $_SESSION['username'] );
		$propInfo = new PropertyInfo( $ain );

		$userResponse['propertyAddress'] = $propInfo->getPropertyAddress();
		$userResponse['ainWithDashes'] = $_SESSION['username'];
		$userResponse['mailingStreet'] = $propInfo->getMailingStreet();
		$userResponse['mailingCity'] = $propInfo->getMailingCity();
		$userResponse['mailingState'] = $propInfo->getMailingState();
		$userResponse['mailingZip'] = $propInfo->getMailingZip();
		$userResponse['propertyAssessment'] = $propInfo->getPropertyAssessment();
		$userResponse['recordSQFT'] = $propInfo->getRecordSQFT();
		$userResponse['recordBedrooms'] = $propInfo->getRecordBedrooms();
		$userResponse['recordBathrooms'] = $propInfo->getRecordBathrooms();

		require( TEMPLATE_PATH . "confirmation.php" );
	}

	function edit() {

	}

	function submit() {
		// TODO: Call function which will send information to the database
		logout();
	}

	function landingpage() {
		require( TEMPLATE_PATH . "landing.php" );
	}
?>