<?php
require('includes/config.php');

//collect values from the url
$userID = trim($_GET['x']);
$active = trim($_GET['y']);

//if id is number and the active token is not empty carry on
if(is_numeric($userID) && !empty($active)){

	//update users record set the active column to Yes where the userID and active value match the ones provided in the array
	$stmt = $db->prepare("UPDATE users SET active = 'Yes' WHERE userID = :userID AND active = :active");
	$stmt->execute(array(
		':userID' => $userID,
		':active' => $active
	));

	//if user is successfully added as a row, redirect to the home page
	if($stmt->rowCount() == 1){

		//return to login page
		header('Location: login.php?action=active');
		exit;

	} else {
		//if row is not updated, return this error
		echo "Your account could not be activated."; 
	}
	
}
?>