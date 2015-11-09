<?php
	
	class PropertyInfo
	{
		public function __construct() {

		}

		public static function getInfoUsingId($ain) {
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

			return $dbResults;
		}
	}

?>