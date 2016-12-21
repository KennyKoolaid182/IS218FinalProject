<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('America/New_York');

//database credentials
define('DBHOST','sql1.njit.edu'); //same
define('DBUSER','kce6'); //kce6
define('DBPASS','t4vydfii'); //pw
define('DBNAME','kce6'); //kce6

//application address
define('DIR','https://web.njit.edu/~kce6/download/');
define('SITEEMAIL','kce6@njit.edu');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>
