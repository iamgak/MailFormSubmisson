<?php
class CheckUp {
    public $name;
    public $email;
    public $phone;
    public $message;
    public $subject;
    public $error = [];

    public function __construct() {
       
        $this->name = $this->sanitize($_POST['name']);
        $this->email = $this->sanitize($_POST['email']);
        $this->phone = $this->sanitize($_POST['phone']);
        $this->message = $this->sanitize($_POST['message']);
        $this->subject = $this->sanitize($_POST['subject']);
    
	}
	


    public function validate() {
        // Validate name
        if (empty($this->name) || !preg_match('/\w{4,}/',$this->name)) {
            $this->error["name"] = "* name should be alphabetical and non empty";
        }

        // Validate email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error["email"] = "* Email is not in proper format.";
        }

        // Validate phone number
        if (!preg_match('/^[0-9]+$/', $this->phone)) {
            $this->error['phone'] = '* Phone number should contain numbers only.';
        }

        // Validate message length
        if (strlen($this->message) < 15) {
            $this->error['message'] = "* Message should contain at least 15 characters.";
        }
        if (strlen($this->subject) < 10) {
            $this->error['subject'] = "* Message should contain at least 10 characters.";
        }

        // Return true if there are no errors
        return empty($this->error);
    }

    private function sanitize($input) {
        // Sanitize input data to prevent security vulnerabilities
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    public function getErrors() {
        return $this->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$test = new CheckUp();//Object Creation 
	
	if($test->validate()){
	try{
		$escapedName = mysqli_real_escape_string($db, $test->name);
		$escapedEmail = mysqli_real_escape_string($db, $test->email);
		$escapedPhone = (int)mysqli_real_escape_string($db, $test->phone);
		$escapedSubject = mysqli_real_escape_string($db, $test->subject);
		$escapedMessage = mysqli_real_escape_string($db, $test->message);
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];}
		else {
			$userIP = $_SERVER['REMOTE_ADDR'];}
		//echo "MY IP address is: " . $userIP;
		$query = "INSERT INTO inputData (name, email, phone, subject, message,ip) VALUES ('$escapedName', '$escapedEmail', $escapedPhone, '$escapedSubject', '$escapedMessage','".$_SERVER['REMOTE_ADDR']."')";
		if ($db->query($query)) {
			$headers = 'From: great@email.com';
    		$mailSent = mail($test->email, $test->subject, $test->message, $headers);
    		if ($mailSent) {
    			header("Location: Success.php");
    		exit();
    		} else {
    			echo 'Error sending email.';}

    		
		} else {
	   		 throw new Exception("Error while inserting");
	   		}
	} 
	catch (Exception $e) {
		$wrong= "**Oops! Something went wrong with your submission. Please try again after rechecking email and phone.Most proably duplicate data or numbers out of range or other Sql problem";}

	}
else{
	$errors=$test->getErrors();
}
}

?>
