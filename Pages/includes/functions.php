<?php

/**
* login function
* 
* This function attempts to login the user
* 
* @params = mysqli object
* returns = boolean (true if connected, false if not)
*/
function login($connection) {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$user = validate_input($_POST['user']);
		$password = hash('sha512', validate_input($_POST['password']));
		

		$checkStudent = "	SELECT *
							FROM student
							WHERE email = ? LIMIT 1;";

		$checkAdvisor = "	SELECT *
							FROM advisor
							WHERE email = ? LIMIT 1;";
		$checkAdmin = "		SELECT *
							FROM head_of_department
							WHERE email = ? LIMIT 1;";								

		// Prepare the statement, bind parameters, then execute!
		// mysqli::prepare returns a mysqli_stmt object or false if an error occurred
		$stmt = $connection->prepare($checkAdvisor);
		$stmt->bind_param('s', $user);
		$stmt->execute();

		// $result stores the mysqli_result object
    	$result = $stmt->get_result(); 

    	$storedAdvisor = $result->fetch_assoc();

    	if (!empty($storedAdvisor)) {
    		if (hash_equals($password, $storedAdvisor['password'])) {
    			// That means the user is an advisor! Let's set the session variables...
    			$_SESSION['fname'] = $storedAdvisor['fname'];
				$_SESSION['lname'] = $storedAdvisor['lname'];
				$_SESSION['advid'] = $storedAdvisor['advid'];
				$_SESSION['password'] = $storedAdvisor['password'];
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['timeout'] = time();

				$connection->close();

				// Take them to the advisor homepage
				header("Location: advisor_home.php");
    		}
    		else {
				// Set the passwordErr variable to display on the login page
				$_SESSION['passwordErr'] = "<p class='error'>* Incorrect password</p>";
				$_SESSION['username'] = $_POST['user'];
				$connection->close();
    		}
    	}elseif(empty($storedAdvisor)){
    		// No match found in the advisor table, so check the student table
			$stmt = $connection->prepare($checkStudent);
			$stmt->bind_param('s', $user);
			$stmt->execute();

	    	$result = $stmt->get_result(); 

	    	$storedStudent = $result->fetch_assoc();
	    	// write_to_file($storedStudent, "Stored Student");
			if (!empty($storedStudent)) {
				if (hash_equals($password, $storedStudent['password'])) {
					// That means the user is a student! Let's set the session variables...
					$_SESSION['fname'] = $storedStudent['fname'];
					$_SESSION['lname'] = $storedStudent['lname'];
					$_SESSION['studentid'] = $storedStudent['studentid'];
					$_SESSION['major'] = $storedStudent['major'];
					$_SESSION['startyear'] = $storedStudent['startyear'];
					$_SESSION['password'] = $storedStudent['password'];
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['timeout'] = time();

					$connection->close();

					// Take them to the student homepage!
					header("Location: form.php");
				}
				else {
					$_SESSION['passwordErr'] = "<p class='error'>* Incorrect password</p>";
					$_SESSION['username'] = $_POST['user'];
					$connection->close();

				}
			}			
		else {
			# No match found in the student table, so check the Head_Of_department 
			$stmt = $connection->prepare($checkAdmin);
			$stmt->bind_param('s', $user);
			$stmt->execute();
				// $result stores the mysqli_result object
			$result = $stmt->get_result(); 

			$storedAdmin=$result->fetch_assoc();
			if(!empty($storedAdmin)){
				if(hash_equals($password,$storedAdmin['password'])){
					// That means the user is a Admin(Head_of_Department)! Let's set the session variables...
					$_SESSION['fname'] = $storedAdmin['fname'];
					$_SESSION['lname'] = $storedAdmin['lname'];
					$_SESSION['AdminID'] = $storedAdmin['AdminID'];
					$_SESSION['password'] = $storedAdmin['password'];
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['timeout'] = time();

					$connection->close();

					// Take them to the Head_Of_Department homepage
					header("Location: Admin_Home.php");
    				}else {
						$_SESSION['passwordErr'] = "<p class='error'>* Incorrect password</p>";
						$_SESSION['username'] = $_POST['user'];
						$connection->close(); 	
					}
				}else {
					$_SESSION['usernameErr'] = "<p class='error'>* Username not found</p>";
					$connection->close();
				}
			}

		}
	}}




/**
* logged_in function
* 
* This function checks if there is a user logged in or not
* First checks if loggedin session variable is set
* If it is set, see if it has timed out or not.
* 
* @params = mysqli object
* returns = boolean (true if connected, false if not)
*/
function logged_in() {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
        if ($_SESSION['timeout'] + 60 * 60 < time()) { // Times out after 60 minutes
	    	return false;
		} else {
		    return true;
		}
    }
    else {
    	return false;
    }
}



/**
* write_to_file function
* 
* This function is used to write the parameter given to a file.
* Meant for debugging purposes.
* 
* @params = String or array()
* @params = String
* returns = void
*/
function write_to_file($param, $name = "\$data") {

	date_default_timezone_set('Jordan/Amman');

	// Specify the file to write to
	$file = __DIR__ . "/debug.txt";
  	$open_file = fopen($file, "a");

  	fwrite($open_file, "\n");

  	$timestamp = "[" . date('M d, Y h:i:s A') . "] " . $name . " = ";
  	fwrite($open_file, $timestamp);

  	if (is_array($param)) {
  		$array2String = print_r($param, TRUE);
  		fwrite($open_file, $array2String);
  	}
  	else if (is_object($param)) {
  		fwrite($open_file, "Is an object and cannot be written.");
  	}
  	else {
  		if ($param == "") {
  			fwrite($open_file, "No Data Found.");
  		} else {
  			fwrite($open_file, $param);
  		}
  	}
    fclose($open_file);
}



/**
* validate_input function
* 
* This function is used to validate user input to protect
* inputs and form fields from code injection.
* 
* @params = String
* returns = String
*/
function validate_input($input) {
	$input = trim($input); // Get rid of any extra white space on either end
	$input = stripslashes($input); // get rid of any slashes '/'
	$input = htmlspecialchars($input); // prevents code injection by preserving html entities
	return $input;
}



/**
* term checker (checks one int)
*/
function validate_term($termid, $takenspace, $i, $status){
	if($termid == 1){
		// Class already taken
		if($takenspace==$i){
			switch ($status) {
				case 'C':
					return "taken";
					break;
				case 'IP':
					return "progress";
					break;
				case 'P':
					return "planned";
					break;
				case 'F':
					return "failed";
					break;
				case 'T':
					return "transferred";
					break;
				default:
					return "taken";
					break;
			}
		} else { // Not taken, but available
			return "available";
		}	
	} else {
		// Closed, toggle off.
		return "closed";
	}
}


/** 
* 
*/
function getCurrentTerm($startyear, $endyear) {
	$currentYear = date('Y'); // 2020
	$currentMonth = date('n'); // 5
	$currentDay = date('j');
	$currentTerm = 0;

	// Each year is separated into 3 sections
	// There are 5 years, so there are 15 (5*3) columns total
	// The following code adds and subtracts numbers from the default
	// in order to figure out what is the current term.
	switch ($currentYear) {
		case $startyear:
			$currentTerm = 1; // Fall of first year
			break;
		case $startyear+1:
			$currentTerm = 4;
			break;
		case $startyear+2:
			$currentTerm = 7;
			break;
		case $startyear+3:
			$currentTerm = 10;
			break;
		case $startyear+4:
			$currentTerm = 13;
			break;
		default:
			return 0;
			break;
	}

	if ($currentMonth >= 1 && $currentMonth < 5 ) {
		// Spring term
		$currentTerm = $currentTerm + 1;
	}
	if ($currentMonth >= 5 && $currentMonth < 9) {
		// Summer term
		$currentTerm = $currentTerm + 2;
	}
	if ($currentMonth == 5 && $currentDay < 9) {
		// Beginning of May is still spring so subtract one
		$currentTerm--;
	}

	return $currentTerm;
}

?>