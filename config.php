<?php
	ini_set( "display_errors", true ); // Causes error messages to be displayed in the browser; turn off on live site
	date_default_timezone_set( "America/Los_Angeles" );  // http://www.php.net/manual/en/timezones.php
	// TODO: Replace name with actual database name
	define( "DB_DSN", "mysql:host=uscitp.com;dbname=tbian_LACounty" ); // Constant that tells PHP where to find MySQL database
	define( "DB_USERNAME", "tbian_test" );
	define( "DB_PASSWORD", "btbtbt@9" );
	define( "CLASS_PATH", "classes" ); // Path in relation to top-level folder, cms
	define( "TEMPLATE_PATH", "templates" ); // Path in relation to top-level folder, cms
	require( CLASS_PATH . "/PropertyInfo.php" );

	function handleException( $exception ) {
		echo "Sorry, a problem occurred. Please try later.";
		error_log( $exception->getMessage() );
	}

	set_exception_handler( 'handleException' );
?>