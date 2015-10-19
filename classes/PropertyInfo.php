<?php
	
	class PropertyInfo
	{
		public function __construct() {

		}

		public static function getInfoUsingId($ain) {
			// Connect to the database using the login details from the config file
			$connection = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
			// Text for the SQL statement; retrieves all the fields for the given id
			// TODO: Replace tableNAme with actual table name
			$sql = "SELECT * FROM tbian_LACounty.DeclineInValue_ParcelStatus WHERE AIN = :ain";
			// Prepare the statement
			$statement = $connection->prepare( $sql );
			// Bind the variable $id to the placeholder :id
			$statement->bindValue( ":ain", $ain, PDO::PARAM_INT );
			// Run the query
			$statement->execute();
			// Retrieve the resulting record as an associative array of field names and corresponding field values
			$record = array();
			$record = $statement->fetch();
			// Close the connection
			$connection = null;

			return $record;
		}
	}

?>