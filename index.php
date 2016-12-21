<?php require('includes/config.php');

//sends users to their profile page
if( $user->is_logged_in() ){ header('Location: profilepage.php'); }

//once submit button is hit, process form
if(isset($_POST['submit'])){

	//validation of information passed by user
	if(strlen($_POST['username']) < 5){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM users WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}

	if(strlen($_POST['password']) < 5){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 5){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}

	}


	//continue to execute if no errors detected in array of errors
	if(!isset($error)){

		//encrypting the password (hashing)
		$passwordhash = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//creates a random, unique code to activate the account
		$activation = md5(uniqid(rand(),true));
		
		//beginning of try/catch statement
		try {

			//Insert statement for the database upon registration
			$stmt = $db->prepare('INSERT INTO users (username,password,email,active) VALUES (:username, :password, :email, :active)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $passwordhash,
				':email' => $_POST['email'],
				':active' => $activation
			));
			$id = $db->lastInsertId('userID');

			//send emails email to users in order to complete verifying their account
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering an account at my website!.</p>
			<p>You are almost done! To continue creating your account, we need to activate your email address.  Please click on the link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Thank you!</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//returns users to the homepage
			header('Location: index.php?action=joined');
			exit;

		//end of try/catch statement
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Homepage';

//code to clean up/set header
require('layout/header.php');
?>


<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Register for an Account</h2>
				<p>Already created an account? Click here <a href='login.php'>Login</a></p>
				<hr>

				<?php
				//checks for errors and echos any errors found
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
				}
				?>

				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2">
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
		</div>
	</div>

</div>

<?php
//code to clean up/set footer
require('layout/footer.php');
?>
