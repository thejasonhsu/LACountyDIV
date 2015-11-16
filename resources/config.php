<?php
	ini_set( "display_errors", true ); // Causes error messages to be displayed in the browser; turn off on live site
	date_default_timezone_set( "America/Los_Angeles" );  // http://www.php.net/manual/en/timezones.php
	
	define( "DB_DSN", "mysql:host=uscitp.com;dbname=tbian_LACounty" ); // Constant that tells PHP where to find MySQL database
	define( "DB_USERNAME", "tbian_test" );
	define( "DB_PASSWORD", "btbtbt@9" );

	define( "PDR_FILE_DATA_TABLE", "tbian_LACounty.ParcelDataRepository_FileDate" ); // ParcelDataRepository_TABLEs_sampleDATA.sql
	define( "PARCEL_DATA_REPOSITORY_TABLE", "tbian_LACounty.ParcelDataRepository" ); // ParcelDataRepository_TABLEs_sampleDATA.sql

	define( "DIV_PARAMETER_DATES_TABLE", "tbian_LACounty.DeclineInValue_ParameterDates" ); // DeclineInValue_ParcelStatus_TABLEs_sampleDATA.sql
	define( "DIV_FILE_DATE_TABLE", "tbian_LACounty.DeclineInValue_FileDate" ); // DeclineInValue_ParcelStatus_TABLEs_sampleDATA.sql
	define( "DIV_PARCEL_STATUS_TABLE", "tbian_LACounty.DeclineInValue_ParcelStatus" ); // DeclineInValue_ParcelStatus_TABLEs_sampleDATA.sql
	
	define( "DIV_FILING_APP_TABLE", "tbian_LACounty.DIVFilingApplicaton" ); // DIVFilingApplication.sql

	define( "TEMPLATE_PATH", "pages/" );
	define( "LIBRARY_PATH", "resources/library" );
	define( "RESOURCE_PATH", "resources/");

	define( "SECRET_KEY", "6Lfw-g0TAAAAAAYutYJAJ_J60xeoieYQSdHoULHt");
	define( "PUBLIC_KEY", "6Lfw-g0TAAAAABDWhGdHei3Bamv8_BIgvNZ9j7_9");

	define( "DEBUG", false );

	require( "resources/library/Rest.php" );
	require( "pages/php/PropertyInfo.php" );
	require( "pages/php/DatabaseEntry.php" );

	function handleException( $exception ) {
		echo "Sorry, a problem occurred. Please try later.";
		error_log( $exception->getMessage() );
	}

	set_exception_handler( 'handleException' );
?>