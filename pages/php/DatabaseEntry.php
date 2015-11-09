<?php

	class DatabaseEntry
	{
		$ain; $applicationXML; $dateTimeAdded; $dateTimeUpdated; $processDate; $emailNotify;

		public function __construct( $dbResults, $userFormResponse ) {

		}

		public function addToDatabase() {
			// TODO: Do we check if the AIN already exists in the table?
			$connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			$sql = "INSERT INTO " . DIV_FILING_APP_TABLE . " ( AIN, ApplicationXML, DateTimeAdded, DateTimeUpdated, ProcessDate, EmailNotify ) VALUES ( :ain, :applicationXML, :dateTimeAdded, :dateTimeUpdated, :processDate, :emailNotify )";
			$statement = $connection->prepare ( $sql );
			$statement->bindValue( ":ain", $this->ain, PDO::PARAM_STR );
			$statement->bindValue( ":applicationXML", $this->applicationXML, PDO::PARAM_STR );
			$statement->bindValue( ":dateTimeAdded", $this->dateTimeAdded, PDO::INT );
			$statement->bindValue( ":dateTimeUpdated", $this->dateTimeUpdated, PDO::INT );
			$statement->bindValue( ":processDate", $this->processDate, PDO::INT );
			$statement->bindValue( ":emailNotify", $this->emailNotify, PDO::INT );
			$statement->execute();
			$connection = null;
		}
	}

?>