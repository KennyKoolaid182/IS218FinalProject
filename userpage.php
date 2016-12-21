<?php require('includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'User Page';

//code for header
require('layout/header.php');
?>

<div class="container">

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
					<li>
							<a href='index.html'>Profile</a>
					</li>
					<li>
							<a href="table.php">User Table</a>
					</li>
					<li>
							<a href='logout.php'>Logout</a>
					</li>
			</ul>
	</div>

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

				<h2>User only page - Welcome <?php echo $_SESSION['username']; ?></h2>
				<p><a href='logout.php'>Logout</a></p>
				<hr>

		</div>
	</div>


</div>

<?php
//code for footer
require('layout/footer.php');
?>
