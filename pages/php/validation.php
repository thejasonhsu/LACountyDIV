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
    list($month, $day, $year) = explode('/', $date);
    if (is_numeric($year) && is_numeric($month) && is_numeric($day)){
        if($month > 12 || $month < 1){
            return false;
        }
        if($day < 1){
            return false;
        }
        if($month == 1 && $day > 31){
            return false;
        }
         if($month == 2 && $day > 28){
            return false;
        }
         if($month == 3 && $day > 31){
            return false;
        }
         if($month == 4 && $day > 30){
            return false;
        }
         if($month == 5 && $day > 31){
            return false;
        }
         if($month == 6 && $day > 30){
            return false;
        }
         if($month == 7 && $day > 31){
            return false;
        }
         if($month == 8 && $day > 31){
            return false;
        }
         if($month == 9 && $day > 30){
            return false;
        }
         if($month == 10 && $day > 31){
            return false;
        }
         if($month == 11 && $day > 30){
            return false;
        }
         if($month == 12 && $day > 31){
            return false;
        }
        return true;
    }
    else{
    	return false;
    }
}


?>