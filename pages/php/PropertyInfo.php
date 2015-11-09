<?php
	
	class PropertyInfo
	{
		private $dbResults;

		public function __construct($ain) {
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
			$this->dbResults = array();
			$this->dbResults = $statement->fetch();
			// Close the connection
			$connection = null;
		}

		public function getInfo() {
			return $this->dbResults;
		}

		public function getPropertyAddress() {
			$addressHouseNo = isset( $this->dbResults['SitusHouseNo'] ) ? $this->dbResults['SitusHouseNo'] : "";
			$addressFraction = isset( $this->dbResults['SitusFraction'] ) ? $this->dbResults['SitusFraction'] : "";
			$addressDirection = isset( $this->dbResults['SitusDirection'] ) ? $this->dbResults['SitusDirection'] : "";
			$addressUnit = isset( $this->dbResults['SitusUnit'] ) ? $this->dbResults['SitusUnit'] : "";
			$addressStreet = isset( $this->dbResults['SitusStreet'] ) ? $this->dbResults['SitusStreet'] : "";
			$addressCity = isset( $this->dbResults['SitusCity'] ) ? $this->dbResults['SitusCity'] : "";
			$addressZip = isset( $this->dbResults['SitusZIP'] ) ? $this->dbResults['SitusZIP'] : "";

			$propertyAddress = $addressHouseNo;
			if ( !empty( $addressFraction ) ) {
				$propertyAddress .= (" " . $addressFraction);
			}
			if ( !empty( $addressDirection ) ) {
				$propertyAddress .= (" " . $addressDirection);
			}
			if ( !empty( $addressUnit ) ) {
				$propertyAddress .= (" " . $addressUnit);
			}
			if ( !empty( $addressStreet ) ) {
				$propertyAddress .= (" " . $addressStreet);
			}
			if ( !empty( $addressCity ) ) {
				$propertyAddress .= (" " . $addressCity);
			}
			if ( !empty( $addressZip ) ) {
				$propertyAddress .= (" " . $addressZip);
			}

			return $propertyAddress;
		}

		public function getMailingStreet() {
			$mailHouseNo = isset( $this->dbResults['MailHouseNo'] ) ? $this->dbResults['MailHouseNo'] : "";
			$mailFraction = isset( $this->dbResults['MailFraction'] ) ? $this->dbResults['MailFraction'] : "";
			$mailDirection = isset( $this->dbResults['MailDirection'] ) ? $this->dbResults['MailDirection'] : "";
			$mailUnit = isset( $this->dbResults['MailUnit'] ) ? $this->dbResults['MailUnit'] : "";
			$mailStreet = isset( $this->dbResults['MailStreet'] ) ? $this->dbResults['MailStreet'] : "";

			$street = $mailHouseNo;
			if ( !empty( $mailFraction ) ) {
				$street .= (" " . $mailFraction);
			}
			if ( !empty( $mailDirection ) ) {
				$street .= (" " . $mailDirection);
			}
			if ( !empty( $mailUnit ) ) {
				$street .= (" " . $mailUnit);
			}
			if ( !empty( $mailStreet ) ) {
				$street .= (" " . $mailStreet);
			}

			return $street;
		}

		public function getMailingCity() {
			if ( isset( $this->dbResults['MailCity'] ) ) {
				$MailCity = $this->dbResults['MailCity'];
				$MailCity = substr( $MailCity, 0, -3 );
				return $MailCity;
			}
			else {
				return "";
			}
		}

		public function getMailingState() {
			if ( isset( $this->dbResults['MailCity'] ) ) {
				$MailCity = $this->dbResults['MailCity'];
				$MailState = substr( $MailCity, -2 );
				return $MailState;
			}
			else {
				return "";
			}
		}

		public function getMailingZip() {
			if ( isset( $this->dbResults['MailZip'] ) ) {
				return $this->dbResults['MailZip'];
			}
			else {
				return "";
			}
		}

		public function getPropertyAssessment() {
			if ( isset( $this->dbResults['RollLandImpValue'] ) ) {
				return $this->dbResults['RollLandImpValue'];
			}
			else {
				return "";
			}
		}

		public function getRecordSQFT() {
			if ( isset( $this->dbResults['SQFTmain'] ) ) {
				return $this->dbResults['SQFTmain'];
			}
			else {
				return "";
			}
		}

		public function getRecordBedrooms() {
			if ( isset( $this->dbResults['Bedrooms'] ) ) {
				return $this->dbResults['Bedrooms'];
			}
			else {
				return "";
			}
		}

		public function getRecordBathrooms() {
			if ( isset( $this->dbResults['Bathrooms'] ) ) {
				return $this->dbResults['Bathrooms'];
			}
			else {
				return "";
			}
		}
	}

?>