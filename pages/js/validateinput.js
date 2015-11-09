/**
 * Checks owner-name textbox for non-empty input.
 * If input is empty, set appropriate error graphics on the page.
 * @param None.
 * @return {boolean} Returns true if input was valid, false otherwise.
 */
function validateOwnerName() {
	//check owner field non-empty
	var ownerName = document.getElementById('owner-name');
	if(ownerName.value.length === 0) {
		//field empty
		ownerName.style.cssText = 'border:1px solid red !important;';
		return false;
	}
	else {
		ownerName.style.cssText = null;	
		return true;
	}
}

/**
 * Checks phone textbox for non-empty input.
 * If input is empty, set appropriate error graphics on the page.
 * @param None.
 * @return {boolean} Returns true if input was valid, false otherwise.
 */
function validateTelephone() {
	var phoneNo = document.getElementById('phone');
	if(phoneNo.value.length === 0) {
		//field empty
		phoneNo.style.cssText = 'border:1px solid red !important;';
		return false;
	}
	else {
		phoneNo.style.cssText = null;	
		return true;
	}
}

/**
 * Checks email textbox for valid input.
 * If input is not a valid email address, set appropriate error graphics on the page.
 * @param None.
 * @return {boolean} Returns true if input was valid, false otherwise.
 */
function validateEmail() {
	var email = document.getElementById('email');
	var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(!reg.test(email.value)) {
		//wrong format
		email.style.cssText = 'border:1px solid red !important;';
		return false;
	}
	else {
		email.style.cssText = null;
		return true;
	}
}

/**
 * Checks confirm-email textbox for valid input.
 * If input is not a valid email address, or it was not equal to to the email field, or if input was empty, set appropriate error graphics on the page.
 * @param None.
 * @return {boolean} Returns true if input was valid, false otherwise.
 */
function validateConfirmEmail() {
	var email = document.getElementById('email');
	var confirmEmail = document.getElementById('confirm-email');
	var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	
	if((email.value !== confirmEmail.value) || (!reg.test(confirmEmail.value)) || (confirmEmail.value.length === 0)) {
		//emails not equal
		confirmEmail.style.cssText = 'border:1px solid red !important;';
		return false;
	}
	else {
		confirmEmail.style.cssText = null;	
		return true;
	}
}

/**
 * Checks userinput-value textbox for non-empty input.
 * If input is empty, set appropriate error graphics on the page.
 * @param None.
 * @return {boolean} Returns true if input was valid, false otherwise.
 */
function validateUserInputValue() {
	var val = document.getElementById('userinput-value');
	if(val.value.length === 0) {
		//value empty
		val.style.cssText = 'border:1px solid red !important;';
		return false;
	}
	else {
		val.style.cssText = null;	
		return true;
	}
}

/**
 * Validates all text boxes that need to be validated.
 * If there is invalid input, set error text at bottom of the page, and error graphics on the sections with invalid input.
 * @param None.
 * @return {boolean} Returns true if all input was valid, false otherwise.
 */
function validateInput() {
	var errMsg = document.getElementById('DIVform-error-message');

	if(!document.getElementById('confirm-checkbox').checked) {
		//confirmation checkbox not checked, output error message
		errMsg.innerHTML = "Please confirm that your application is correct by clicking the checkbox below."
		return false;
	}
	else {
		errMsg.innerHTML = "";
	}

	var valid = true;

	//IMPORTANT: the use of the bitwise AND operator here, '&', is necessary to prevent short-circuit behavior. Do NOT change it to the regular AND oeprator, '&&'.
	if(!(validateOwnerName() & validateTelephone() & validateEmail() & validateConfirmEmail())) {
		//set error flags on owner information section
		valid = false;
		var warning = new Image();
		warning.src = 'http://scf.usc.edu/~yangkevi/warning.png';
		var img = document.getElementById('warning-icon1');
		img.src = warning.src;
		document.getElementById('owner-info').style.cssText = "color:red !important";
	}
	else {
		var img = document.getElementById('warning-icon1');
		img.style.display = 'none';
		document.getElementById('owner-info').style.cssText = null;	
	}

	if(!validateUserInputValue()) {
		//set error flags on property info section
		valid = false;
		var img = document.getElementById('warning-icon2');
		img.src = 'http://scf.usc.edu/~yangkevi/warning.png';
		document.getElementById('property-info').style.cssText = "color:red !important";
	}	
	else {
		var img = document.getElementById('warning-icon2');
		img.style.display = 'none';
		document.getElementById('property-info').style.cssText = null;	
	}

	if(!valid) {
		//set error text at bottom of the page
		errMsg.innerHTML = "You have one or more errors in your application. Please review the form for the highlighted errors and correct them."
		return false;
	}
	else {
		errMsg.innerHTML = "";
		return true;
	}
}