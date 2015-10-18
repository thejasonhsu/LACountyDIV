<?php
	ini_set( "display_errors", true ); // Causes error messages to be displayed in the browser; turn off on live site
	date_default_timezone_set( "America/Los_Angeles" );  // http://www.php.net/manual/en/timezones.php
	define( "DB_DSN", "mysql:host=localhost;dbname=cms" ); // Constant that tells PHP where to find MySQL database
	define( "DB_USERNAME", "root" );
	define( "DB_PASSWORD", "" );
	define( "CLASS_PATH", "classes" ); // Path in relation to top-level folder, cms
	define( "TEMPLATE_PATH", "templates" ); // Path in relation to top-level folder, cms

	function handleException( $exception ) {
		echo "Sorry, a problem occurred. Please try later.";
		error_log( $exception->getMessage() );
	}

	set_exception_handler( 'handleException' );
?>