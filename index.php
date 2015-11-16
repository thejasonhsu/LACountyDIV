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
		case 'submit':
			submit();
			break;
		case 'logout':
			logout();
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
			$loginError = true;
			$errorMessage = "Please verify that you are a human by checking 'I'm not a robot.'";
			require( TEMPLATE_PATH . "landing.php" );
			return;
		}

		$response = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'] );
		$response = json_decode( $response );

		if( $response->success == false ) {
			// Error: Captcha was not successful
			logout();
			return;
		}

		// Check that valid AIN and PIN were given
		$loginError = NULL;
		$validMatch = false;
		$ain; $pin; $ainWithDashes;

		if ( isset( $_POST['AIN'] ) && isset( $_POST['PIN'] ) ) {

				$ain = $_POST['AIN'];
				$pin = $_POST['PIN'];

				$ainWithDashes = $ain;

				// Remove dashes from AIN
				$ain = str_replace( "-", "", $ain );

				// Pass ain and pin to rest service
				$loginData = json_encode( array( 'ain' => $ain,'pin' => $pin ), JSON_FORCE_OBJECT );
				$restResult = Rest::restValidate( $loginData );

				if ( strcmp( $restResult, "success" ) == 0 ) {					
					$validMatch = true;
				}
				else {
					// Error: AIN and PIN did not match					
					$validMatch = false;
					$loginError = true;
					$errorMessage = "Incorrect AIN/PIN.";
					require( TEMPLATE_PATH . "landing.php" );
					return;
				}
		}
		else {
			// Error: User did not enter both an AIN and PIN
			$loginError = true;
			$errorMessage = "Incorrect AIN/PIN.";
			require( TEMPLATE_PATH . "landing.php" );
			return;
		}

		if ( $validMatch && $response->success ) {
			$_SESSION['username'] = $ainWithDashes;

			form($ain, $ainWithDashes); // Question: Should we make appform the default and use header instead of require when they sign in?
		}
		else {
			// Error: Invalid combination
			$loginError = true;
			$errorMessage = "Incorrect AIN/PIN.";
			require( TEMPLATE_PATH . "landing.php" );
			return;
		}
	}

	function logout() {
		session_unset();
		session_destroy();
		//session_write_close();
		setcookie(session_name(),'',0,'/');
		//session_regenerate_id(true);
		header( "Location: index.php" );
	}

	function form($ain, $ainWithDashes) {
		$propInfo = new PropertyInfo( $ain );
		$dbResults = $propInfo->getInfo();
		$_SESSION['propertyInfo'] = $propInfo;

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
		$propInfo = $_SESSION['propertyInfo'];

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

		$_SESSION['userFormResponse'] = $userResponse;

		require( TEMPLATE_PATH . "confirmation.php" );
	}

	function edit() {
		$propInfo = $_SESSION['propertyInfo'];
		$dbResults = $propInfo->getInfo();
		
		require( TEMPLATE_PATH . "appform.php" );
	}

	function submit() {
		$userResponse = $_SESSION['userFormResponse'];
		$propertyInfo = $_SESSION['propertyInfo']->getInfo();

		// End session
		session_unset();
		session_destroy();
		setcookie(session_name(),'',0,'/');

		$dbEntry = new DatabaseEntry( $propertyInfo, $userResponse );
		$successfulEntry = $dbEntry->addToDatabase();

		if (DEBUG) {
			$temp = ($successfulEntry) ? 'true' : 'false';
			echo "<p></p>";
			echo "successfulEntry = " . $temp;
		}
		else {
			require( TEMPLATE_PATH . "thankyou.php" );
		}
	}

	function landingpage() {
		require( TEMPLATE_PATH . "landing.php" );
	}
?>