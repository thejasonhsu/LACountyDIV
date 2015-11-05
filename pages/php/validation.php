<?php



function validatePhoneNumber($phoneNum)
{
    if(strlen($phoneNum) == 10 && is_numeric($phoneNum)){
    	return true;
    } 
    else{
    	return false;
    }
}

function validateAIN($ain)
{
    if(strlen($ain) == 10 && is_numeric($ain)){
    	return true;
    } 
    else{
    	return false;
    }
}

function confirmEmail($email1, $email2){
	//check to see if user typed in the same two emails for confirmation
	if($email1 == $email2){
		return true;
	}
	else{
		return false;
	}
}

function validateOpinionOfVal($opinion)
{
    if(strlen($opinion) <= 9 && is_numeric($ain)){
    	return true;
    } 
    else{
    	return false;
    }
}

function validateSquareFootage($sqFt)
{
    if(strlen($sqFt) <= 9 && is_numeric($sqFt)){
    	return true;
    } 
    else{
    	return false;
    }
}

function validateBedroomNumber($numBed)
{
    if(strlen($numBed) <= 9 && is_numeric($numBed)){
    	return true;
    } 
    else{
    	return false;
    }
}

function validateBathroomNumber($numBath)
{
    if(strlen($numBath) <= 9 && is_numeric($numBath)){
    	return true;
    } 
    else{
    	return false;
    }
}

function validateZipCode($zip)
{
    if(strlen($zip) == 5 && is_numeric($zip)){
    	return true;
    } 
    else{
    	return false;
    }
}

function validateSalePrice($price)
{
    if(strlen($price) <= 9 && is_numeric($price)){
    	return true;
    } 
    else{
    	return false;
    }
}

function validateSaleDate($date)
{
    if(strlen($date) == 9 && is_numeric($date)){
    	return true;
    } 
    else{
    	return false;
    }
}







?>