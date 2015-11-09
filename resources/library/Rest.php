<?php

class Rest
{
	public static function restValidate( $loginData ) {
		$testLoginPairs = array (
							"2004001003" => "1003",
							"2004001004" => "1004",
							"2004001019" => "1019",
							"2004001028" => "1028",
							"2004002006" => "2006",
							"2004002023" => "2023",
							"2007009041" => "9041" );

		$recievedData = json_decode( $loginData );

		$recievedAin = $recievedData->ain;
		$recievedPin = $recievedData->pin;

		if ( array_key_exists( $recievedAin, $testLoginPairs ) ) {
			if ( $testLoginPairs[$recievedAin] == $recievedPin ) {
				return "success";
			}
			else {
				return "fail";
			}
		}
		else {
			return "fail";
		}
	}
}

?>