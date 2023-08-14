<?php
include('config.php');
include('FormClass.php');?>
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
