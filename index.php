<?php
	require( "config.php" );
	$array = PropertyInfo::getInfoUsingId(2023007025);
	print_r($array);
	echo "The AIN for the record requested is: ";
	echo $array['AIN'];
?>