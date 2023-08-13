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
            $this->error["name"] = "* name err.";
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
        if (strlen($this->message) < 10) {
            $this->error['message'] = "* Message should contain at least 10 characters.";
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
	//some conditions or database query most proably
	//the only problem is mail()
	//asap->mail()
	// Assuming you have a mysqli connection named $db
	try{
	$escapedName = mysqli_real_escape_string($db, $test->name);
	$escapedEmail = mysqli_real_escape_string($db, $test->email);
	$escapedPhone = mysqli_real_escape_string($db, $test->phone);
	$escapedSubject = mysqli_real_escape_string($db, $test->subject);
	$escapedMessage = mysqli_real_escape_string($db, $test->message);

	$query = "INSERT INTO inputData (name, email, phone, subject, message) VALUES ('$escapedName', '$escapedEmail', '$escapedPhone', '$escapedSubject', '$escapedMessage')";

		if ($db->query($query)) {
    		
    		header("Location: FormMail.php");
    		exit();
		} else {
	   		 throw new Exception("Error while inserting");
	   		}} catch (Exception $e) {
    echo "Oops! Something went wrong with your submission. Please try again later.Most proably duplicate data";
}

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
</head>
<body>
	<div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><div>
    Namw: *<input type="text" name="name" placeholder="Enter name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
    <?php if (isset($errors["name"])) { echo $errors["name"]; } ?></div>
    <div>
    Phone: *<input type="text" name="phone" placeholder="Enter phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
    <?php if (isset($errors["phone"])) { echo $errors["phone"]; } ?></div>
    <div>
    Email: *<input type="email" name="email" placeholder="Enter email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
    <?php if (isset($errors["email"])) { echo $errors["email"]; } ?></div><div>
    	<div>
    		Subject: <input type="text" name="subject" value='<?php echo isset($_POST['subject'])?$_POST['subject']: "";?>'>
    	</div>
    Message: *<textarea name="message" placeholder="Enter message"><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
    <?php if (isset($errors["message"])) { echo $errors["message"]; } ?></div><div>
    <input type="submit" name="submit"></div>
</form>
</div>
</body>
</html>
