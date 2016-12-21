<?php require('includes/config.php');

//logout
$user->logout(); 

//redirects user to homepage (index)
header('Location: index.php');
exit;
?>