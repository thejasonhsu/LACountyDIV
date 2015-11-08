<?php
	require( "resources/config.php" );
	require( "resources/library/Rest.php" );

	session_start();
	$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	//$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

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

		$response = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'] );
		$response = json_decode( $response );

		if( $response->success == false ) {
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
			form($ain, $ainWithDashes);
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
		// Is there a formal logout? Where do we redirect them?
	}

	function form($ain, $ainWithDashes) {
		// Connect to the database using the login details from the config file
		$connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		// Text for the SQL statement; retrieves all the fields for the given id
		$sql = "SELECT * FROM " . PARCEL_DATA_REPOSITORY_TABLE . " WHERE AIN = :ain";
		// Prepare the statement
		$statement = $connection->prepare( $sql );
		// Bind the variable $id to the placeholder :id
		$statement->bindValue( ":ain", $ain, PDO::PARAM_INT );
		// Run the query
		$statement->execute();
		// Retrieve the resulting record as an associative array of field names and corresponding field values
		$dbResults = array();
		$dbResults = $statement->fetch();
		// Close the connection
		$connection = null;

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
		// TODO: Add name to additional information textarea
		// TODO: Add name to checkbox confirmation

		require( TEMPLATE_PATH . "confirmation.php" );
	}

	function submit() {
		
	}

	function landingpage() {
		require( TEMPLATE_PATH . "landing.php" );
	}

	/*$array = PropertyInfo::getInfoUsingId(2023007025);
	print_r($array);
	echo "The AIN for the record requested is: ";
	echo $array['AIN'];*/
?>