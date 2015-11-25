<?php
	require( "resources/config.php" );

	session_start();
	$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

	if ( $action != "login" && $action != "logout" && !$username && $action != "reviewLanding" && $action != "reviewLogin" ) {
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
		case 'reviewLanding':
			reviewLanding();
			break;
		case 'reviewLogin':
			reviewLogin();
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

				// TODO: Clear session variables and reset pin

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
		setcookie(session_name(),'',0,'/');
		landingpage();
	  	exit;
	}

	function form($ain, $ainWithDashes) {
		$propInfo = new PropertyInfo( $ain );
		$dbResults = $propInfo->getInfo();
		$_SESSION['propertyInfo'] = $propInfo;

		$parameters;
		if ( array_key_exists( 'parameters', $_SESSION ) ) {
			$parameters = $_SESSION['parameters'];
		}
		else {
			$parameters = getParameters();
		}

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

		$parameters;
		if ( array_key_exists( 'parameters', $_SESSION ) ) {
			$parameters = $_SESSION['parameters'];
		}
		else {
			$parameters = getParameters();
		}
		
		require( TEMPLATE_PATH . "appform.php" );
	}

	function submit() {
		$userResponse = $_SESSION['userFormResponse'];
		$propertyInfo = $_SESSION['propertyInfo']->getInfo();

		// End session
		session_unset();
		session_destroy();
		setcookie( session_name(),'',0,'/' );

		$dbEntry = new DatabaseEntry( $propertyInfo, $userResponse );
		$successfulEntry = $dbEntry->addToDatabase();

		if (DEBUG) {
			$temp = ($successfulEntry) ? 'true' : 'false';
			echo "<p></p>";
			echo "successfulEntry = " . $temp;
		}
		else {
			if ($successfulEntry) {
				require( TEMPLATE_PATH . "thankyou.php" );
			}
			else {
				require( TEMPLATE_PATH . "error.php" );
			}
		}
	}

	function landingpage() {
		$year = date( "Y" );
		$year = intval( $year );

		$_SESSION['parameters'] = getParameters();

		if ( LANDING_DEBUG ) {
			$temp = ($success) ? 'true' : 'false';
			echo "Retrieving the information was a success: " . $temp;
			
			print "<pre>";
			print_r( $parameters );
			print "</pre>";
		}
		else {
			require( TEMPLATE_PATH . "landing.php" );
		}
	}

	function reviewLanding() {
		$year = date( "Y" );
		$year = intval( $year );

		require( TEMPLATE_PATH . "decline-in-value-review.php" );
	}

	function reviewLogin() {
		$ain = $_POST['AIN'];
		$ainWithDashes = $ain;
		$ain = str_replace( "-", "", $ain );

		// End session
		session_unset();
		session_destroy();
		setcookie(session_name(),'',0,'/');

		$informationString = getStatusView($ain);

		if ( strcmp( $informationString, "Error" ) == 0 ) {
			// Show error - no property results
			require( TEMPLATE_PATH . "decline-in-value-review.php" );
		}
		else {
			require( TEMPLATE_PATH . "review-status.php" );
		}
	}

	function getParameters() {
		$parameters = array();
		$year = date( "Y" );
		$year = intval( $year );

		$connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$sql = "SELECT * FROM " . DIV_PARAMETER_DATES_TABLE . " WHERE RollYYYY = :rollyyyy";
		$statement = $connection->prepare( $sql );
		$statement->bindValue( ":rollyyyy", $year, PDO::PARAM_INT );
		$success = $statement->execute();
		$parameters = $statement->fetch();
		$connection = null;

		$parameters['Prop8Application_FileDateBegin'] = date( "F j, Y", strtotime( $parameters['Prop8Application_FileDateBegin'] ) );
		$parameters['Prop8Application_FileDateEnd'] = date( "F j, Y", strtotime( $parameters['Prop8Application_FileDateEnd'] ) );
		$parameters['LienDate'] = date( "F j, Y", strtotime( $parameters['LienDate'] ) );

		return $parameters;
	}

?>