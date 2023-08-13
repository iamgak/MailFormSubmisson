<?php
include('config.php');

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
$test = new CheckUp();
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
    		if (!$mailSent) {
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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Submission</title>
      <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            font-weight: bold;
        }
        
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }
        
        .error {
            color: red;
        }
        
        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
	<div class="container">
	<h1>Online Form For Nothing</h1>
	<div class="error"><?php echo isset($wrong)?$wrong:"";?></div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<fieldset>
	<legend>Form Submisson</legend>
	<div class="form-group">
		<label for ="name">Name: *</label> 
		<input type="text" name="name" placeholder="Enter name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
		<div class="error"><?php if (isset($errors["name"])) { echo $errors["name"]; } ?></div>
	</div>
	<div class="form-group">
	    <label for ="phone">Phone: *</label>
	    <input type="text" name="phone" placeholder="Enter phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
	    <div class="error"><?php if (isset($errors["phone"])) { echo $errors["phone"]; } ?></div>
	</div>
    	
    <div class="form-group">
	    <label for ="email">Email: *</label>
	    <input type="email" name="email" placeholder="Enter email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
	    <div class="error"><?php if (isset($errors["email"])) { echo $errors["email"]; } ?></div>
    </div>
    	<div class="form-group">
    		<label for ="subject">Subject: * </label>
    		<input type="text" name="subject" value='<?php echo isset($_POST['subject'])?$_POST['subject']: "";?>'>
		<div class="error"><?php echo isset($errors['subject']) ? $errors['subject']:"";  ?></div>
	</div>
    	<div class="form-group">
    		<label for ="message">Message: *</label>
    		<textarea name="message" placeholder="Enter message"><?php if (isset($_POST['message'])){ echo $_POST['message'] ;} ?></textarea>
		<div class="error"><?php  if (isset($errors['subject'])){ echo $errors['subject'] ;}  ?></div>
	</div>
    <input type="submit" name="submit"></div>
</fieldset>
</form>
</div>
</body>
</html>
