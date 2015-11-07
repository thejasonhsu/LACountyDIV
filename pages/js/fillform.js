// Loads in user info to DIV form
function fillForm() {
	//Set property address fields
	var SitusHouseNo = "<?php echo $dbResults['SitusHouseNo'] ?>";
	var SitusFraction = "<?php echo $dbResults['SitusFraction'] ?>";
	var SitusDirection = "<?php echo $dbResults['SitusDirection'] ?>";
	var SitusUnit = "<?php echo $dbResults['SitusUnit'] ?>";
	var SitusStreet = "<?php echo $dbResults['SitusStreet'] ?>";
	var SitusCity = "<?php echo $dbResults['SitusCity'] ?>";
	var SitusZIP = "<?php echo $dbResults['SitusZIP'] ?>";
	var SitusAddress = SitusHouseNo + " " + SitusFraction + " "
					+ SitusDirection + " " + SitusUnit + " "
					+ SitusStreet + " " + SitusCity + " "
					+ SitusZIP;
	SitusAddress = SitusAddress.replace(/\s+/g, ' ');
	document.getElementById('PropertyInfo_lblPropertyAddress').innerHTML = SitusAddress;

	// Set AIN fields
	var AIN = "<?php echo $dbResults['AIN'] ?>";
	document.getElementById('PropertyInfo_lblAIN').innerHTML = AIN;	

	// Set assessed value fields
	var RollLandImpValue = "<?php echo $dbResults['RollLandImpValue'] ?>";
	document.getElementById('lblAssessedValue1').innerHTML = "$" + RollLandImpValue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

	// Set year of assessment fields
	var RollYYYY = "<?php echo $dbResults['RollYYYY'] ?>";
	var arr = document.getElementsByClassName('lblAssessedYear');
	for(i = 0; i < arr.length; i++) {
		arr[i].innerHTML = RollYYYY;
	}

	/*  TODO DOCUMENTATION - MUST READ
		
		In the table 'ParcelDataRepository', there is an attribute
		'MailCity' which includes both the city and state. For example,
		'LOS ANGELES CA'. In the 'Mailing Address On File' section inside
		appform.php, city and state need to be separated. The way this
		function separates the city and state names is by taking the last
		2 letters of the string and making it the State. Therefore,
		you must ensure that the 'MailCity' attribute always includes the
		two-letter state code at the end of an entry.
	 */

	// Set mailing address fields
	var MailHouseNo = "<?php echo $dbResults['MailHouseNo'] ?>";
	var MailFraction = "<?php echo $dbResults['MailFraction'] ?>";
	var MailDirection = "<?php echo $dbResults['MailDirection'] ?>";
	var MailUnit = "<?php echo $dbResults['MailUnit'] ?>";
	var MailStreet = "<?php echo $dbResults['MailStreet'] ?>";
	var MailCity = "<?php echo $dbResults['MailCity'] ?>";
	var MailState = MailCity.slice(MailCity.length - 2);
	MailCity = MailCity.slice(0, MailCity.length - 3);
	var MailZIP = "<?php echo $dbResults['MailZip'] ?>";
	var MailAddress = MailHouseNo + " " + MailFraction + " "
					+ MailDirection + " " + MailUnit + " "
					+ MailStreet;
	MailAddress = MailAddress.replace(/\s+/g, ' ');

	document.getElementById('lblMailStreet').innerHTML = MailAddress; 
	document.getElementById('lblMailCity').innerHTML = MailCity;
	document.getElementById('lblMailState').innerHTML = MailState;
	document.getElementById('lblMailZip').innerHTML = MailZIP;
	
	// Set square footage fields
	var SQFTmain = "<?php echo $dbResults['SQFTmain'] ?>";
	document.getElementById('lblSQFTmain').innerHTML = SQFTmain;

	// Set # of bedrooms fields
	var Bedrooms = "<?php echo $dbResults['Bedrooms'] ?>";
	document.getElementById('lblBedrooms').innerHTML = Bedrooms;

	// Set # of bathrooms fields
	var Bathrooms = "<?php echo $dbResults['Bathrooms'] ?>";
	document.getElementById('lblBathrooms').innerHTML = Bathrooms;
}