<?php
	require( "resources/config.php" );

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

			form($ain);
		}
		else {
			// Error: Show that it was an invalid combination
		}
	}

	function logout() {
		unset( $_SESSION['username'] );
		// Is there a formal logout? Where do we redirect them?
	}

	function form($ain) {
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
		$ownerName = isset( $_POST['OwnerName'] ) ? $_POST['OwnerName'] : "";
		$telephone = isset( $_POST['Telephone'] ) ? $_POST['Telephone'] : "";
		$email = isset( $_POST['Email'] ) ? $_POST['Email'] : "";
		$confirmEmail = isset( $_POST['ConfirmEmail'] ) ? $_POST['ConfirmEmail'] : "";
		$projectedAssessedValue = isset( $_POST['ProjectedAssessedValue'] ) ? $_POST['ProjectedAssessedValue'] : "";
		$opinionOfValue = isset( $_POST['OpinionOfValue'] ) ? $_POST['OpinionOfValue'] : "";
		$propertyType = isset( $_POST['PropertyType'] ) ? $_POST['PropertyType'] : "";
		$approxSqFootage = isset( $_POST['ApproxSqFootage'] ) ? $_POST['ApproxSqFootage'] : "";
		$numBedrooms = isset( $_POST['NumBedrooms'] ) ? $_POST['NumBedrooms'] : "";
		$numBathrooms = isset( $_POST['NumBathrooms'] ) ? $_POST['NumBathrooms'] : "";
		$comp1Address = isset( $_POST['Comp1Address'] ) ? $_POST['Comp1Address'] : "";
		$comp1City = isset( $_POST['Comp1City'] ) ? $_POST['Comp1City'] : "";
		$comp1Zip = isset( $_POST['Comp1Zip'] ) ? $_POST['Comp1Zip'] : "";
		$comp1AIN = isset( $_POST['Comp1AIN'] ) ? $_POST['Comp1AIN'] : "";
		$comp1SaleDate = isset( $_POST['Comp1SaleDate'] ) ? $_POST['Comp1SaleDate'] : "";
		$comp1SalePrice = isset( $_POST['Comp1SalePrice'] ) ? $_POST['Comp1SalePrice'] : "";
		$comp1Description = isset( $_POST['Comp1Description'] ) ? $_POST['Comp1Description'] : "";
		$comp2Address = isset( $_POST['Comp2Address'] ) ? $_POST['Comp2Address'] : "";
		$comp2City = isset( $_POST['Comp2City'] ) ? $_POST['Comp2City'] : "";
		$comp2Zip = isset( $_POST['Comp2Zip'] ) ? $_POST['Comp2Zip'] : "";
		$comp2AIN = isset( $_POST['Comp2AIN'] ) ? $_POST['Comp2AIN'] : "";
		$comp2SaleDate = isset( $_POST['Comp2SaleDate'] ) ? $_POST['Comp2SaleDate'] : "";
		$comp2Description = isset( $_POST['Comp2Description'] ) ? $_POST['Comp2Description'] : "";
		$comp2SalePrice = isset( $_POST['Comp2SalePrice'] ) ? $_POST['Comp2SalePrice'] : "";
		// TODO: Add name to additional information textarea
		// TODO: Add name to checkbox confirmation

		// DEBUG
		echo '<p></p>';
		echo "OwnerName: " . $ownerName;
		echo '<p></p>';
		echo "Telephone: " . $telephone;
		echo '<p></p>';
		echo "Email: " . $email;
		echo '<p></p>';
		echo "ConfirmEmail: " . $confirmEmail;
		echo '<p></p>';
		echo "ProjectedAssessedValue: " . $projectedAssessedValue;
		echo '<p></p>';
		echo "OpinionOfValue: " . $opinionOfValue;
		echo '<p></p>';
		echo "PropertyType: " . $propertyType;
		echo '<p></p>';
		echo "ApproxSqFootage: " . $approxSqFootage;
		echo '<p></p>';
		echo "NumBedrooms: " . $numBedrooms;
		echo '<p></p>';
		echo "NumBathrooms: " . $numBathrooms;
		echo '<p></p>';
		echo "Comp1Address: " . $comp1Address;
		echo '<p></p>';
		echo "Comp1City: " . $comp1City;
		echo '<p></p>';
		echo "Comp1Zip: " . $comp1Zip;
		echo '<p></p>';
		echo "Comp1SaleDate: " . $comp1SaleDate;
		echo '<p></p>';
		echo "Comp1SalePrice: " . $comp1SalePrice;
		echo '<p></p>';
		echo "Comp1Description: " . $comp1Description;
		echo '<p></p>';
		echo "Comp2Address: " . $comp2Address;
		echo '<p></p>';
		echo "Comp2City: " . $comp2City;
		echo '<p></p>';
		echo "Comp2Zip: " . $comp2Zip;
		echo '<p></p>';
		echo "Comp2AIN: " . $comp2AIN;
		echo '<p></p>';
		echo "Comp2SaleDate: " . $comp2SaleDate;
		echo '<p></p>';
		echo "Comp2SalePrice: " . $comp2SalePrice;
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