<?php
	require( "pages/php/validation.php" );

	class DatabaseEntry
	{
		private $ain;
		private $applicationXML;
		private $dateTimeAdded;
		private $dbResults;
		private $userFormResponse;

		public function __construct( $dbr, $ufr ) {
			$this->dbResults = $dbr;
			$this->userFormResponse = $ufr;

			$this->ain = isset( $dbr['AIN'] ) ? $dbr['AIN'] : "";
			
			if ( !empty($this->ain) ) {
				$this->applicationXML = 
				"<OnlineFiling>
					<Application>
						<FilingStatus></FilingStatus>
						<FilingMethod>Online</FilingMethod>
						<Requestor>Owner</Requestor>
						<PDBParcel>
							<AIN>{$dbr['AIN']}</AIN>
							<UseType>{$ufr['propertyType']}</UseType>
							<Region>{$dbr['Region']}</Region>
							<Cluster>{$dbr['Cluster']}</Cluster>
							<ParcelStatus>{$dbr['ParcelStatus']}</ParcelStatus>
							<pdbRecDate>{$dbr['pdbRecDate']}</pdbRecDate>
							<AssessedValue>{$dbr['RollLandImpValue']}</AssessedValue>
							<SitusStreet>{$dbr['SitusStreet']}</SitusStreet>
							<SitusCity>{$dbr['SitusCity']}</SitusCity>
							<SitusZip>{$dbr['SitusZip']}</SitusZip>
							<SQFTmain>{$ufr['approxSqFootage']}</SQFTmain>
							<Bedrooms>{$ufr['numBedrooms']}</Bedrooms>
							<Bathrooms>{$ufr['numBathrooms']}</Bathrooms>
							<Units>{$dbr['Units']}</Units>
							<Description></Description>
						</PDBParcel>
						<Owner>
							<AssesseeName>{$ufr['ownerName']}</AssesseeName>
							<DayTimePhone>{$ufr['telephone']}</DayTimePhone>
							<EmailAddress>{$ufr['email']}</EmailAddress>
							<isMailCopySitus>{$dbr['isMailCopySitus']}</isMailCopySitus>
							<MailingStreet>{$ufr['mailingStreet']}</MailingStreet>
							<MailingCity>{$ufr['mailingCity']}</MailingCity>
							<MailingState>{$ufr['mailingState']}</MailingState>
							<MailingZip>{$ufr['mailingZip']}</MailingZip>
						</Owner>
						<Agent>
							<Name></Name>
							<DayTimePhone></DayTimePhone>
							<EmailAddress></EmailAddress>
							<MailingStreet></MailingStreet>
							<MailingCity></MailingCity>
							<MailingState></MailingState>
							<MailingZip></MailingZip>
						</Agent>
						<UserInput>
							<EmailNotify>N</EmailNotify>
							<OpinionValue>{$ufr['opinionOfValue']}</OpinionValue>
							<AddtionalInfo>{$ufr['additionalInfo']}</AddtionalInfo>
							<SubmitDate></SubmitDate>
							<Comparables>
								<Property Sale=\"1\">
									<Address>{$ufr['comp1Address']}</Address>
									<City>{$ufr['comp1City']}</City>
									<Zip>{$ufr['comp1Zip']}</Zip>
									<AIN>{$ufr['comp1AIN']}</AIN>
									<SaleDate>{$ufr['comp1SaleDate']}</SaleDate>
									<SalePrice>{$ufr['comp1SalePrice']}</SalePrice>
									<Description>{$ufr['comp1Description']}</Description>
								</Property>
								<Property Sale=\"2\">
									<Address>{$ufr['comp2Address']}</Address>
									<City>{$ufr['comp2City']}</City>
									<Zip>{$ufr['comp2Zip']}</Zip>
									<AIN>{$ufr['comp2AIN']}</AIN>
									<SaleDate>{$ufr['comp2SaleDate']}</SaleDate>
									<SalePrice>{$ufr['comp2SalePrice']}</SalePrice>
									<Description>{$ufr['comp2Description']}</Description>
								</Property>
							</Comparables>
						</UserInput>
					</Application>
				</OnlineFiling>";

				// DEBUG
				echo "applicationXML = " . $this->applicationXML;
				echo "<p></p>";
			}
		}

		public function addToDatabase() {
			// TODO: Do we check if the AIN already exists in the table?
			if ( !empty( $this->ain ) && $this->validData() ) {
				$this->dateTimeAdded = date("Y-m-d H:i:s");

				$connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$sql = "INSERT INTO " . DIV_FILING_APP_TABLE . " ( AIN, ApplicationXML, DateTimeAdded ) VALUES ( :ain, :applicationXML, :dateTimeAdded )";
				$statement = $connection->prepare ( $sql );
				$statement->bindValue( ":ain", $this->ain, PDO::PARAM_STR );
				$statement->bindValue( ":applicationXML", $this->applicationXML, PDO::PARAM_STR );
				$statement->bindValue( ":dateTimeAdded", $this->dateTimeAdded, PDO::INT );
				$statement->execute();
				$connection = null;



				// DEBUG
				$connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
				$sql = "SELECT * FROM " . DIV_FILING_APP_TABLE . " WHERE AIN = :ain";
				$statement = $connection->prepare( $sql );
				$statement->bindValue( ":ain", $this->ain, PDO::PARAM_INT );
				$statement->execute();
				$debugResults = array();
				$debugResults = $statement->fetch();
				$connection = null;
				echo "Database debugging result: ";
				echo $debugResults;



				return true;
			}

			return false;
		}

		public function validData() {
			if ( !validateAIN( $this->dbResults['AIN'] ) ) {
				return false;
			}
			if ( !validatePhoneNumber( $this->userFormResponse['telephone'] ) ) {
				return false;
			}
			if ( !validateOpinionOfVal( $this->userFormResponse['opinionOfValue'] ) ) {
				return false;
			}
			if ( !validateSquareFootage( $this->userFormResponse['approxSqFootage'] ) ) {
				return false;
			}
			if ( !validateBedroomNumber( $this->userFormResponse['numBedrooms'] ) ) {
				return false;
			}
			if ( !validateBathroomNumber( $this->userFormResponse['numBathrooms'] ) ) {
				return false;
			}
			if ( !validateZipCode( $this->userFormResponse['comp1Zip'] ) ) {
				return false;
			}
			if ( !validateZipCode( $this->userFormResponse['comp2Zip'] ) ) {
				return false;
			}
			if ( !validateZipCode( $this->userFormResponse['mailingZip'] ) ) {
				return false;
			}
			if ( !validateSalePrice( $this->userFormResponse['comp1SalePrice'] ) ) {
				return false;
			}
			if ( !validateSalePrice( $this->userFormResponse['comp2SalePrice'] ) ) {
				return false;
			}
			if ( !validateSaleDate( $this->userFormResponse['comp1SaleDate'] ) ) {
				return false;
			}
			if ( !validateSaleDate( $this->userFormResponse['comp2SaleDate'] ) ) {
				return false;
			}
			return true;
		}
	}

?>