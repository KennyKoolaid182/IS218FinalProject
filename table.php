<?php require('includes/config.php');

//redirects to homepage when no user is logged in
if(!$user->is_logged_in()){ header('Location: login.php'); }

//Title of Page
$title = 'User Page';

//code for header set up
require('layout/header.php'); 
?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            
                <h2>Table of Users . Current User is <?php echo $_SESSION['username']; ?></h2>
                <p><a href='logout.php'>Logout</a></p>
                <hr>

        </div>
  <div id="ccontent">
  <p>
  <?php 
  $con=mysqli_connect("sql2.njit.edu","kce6","t4dydfii","kce6");
// Check connection for erros
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM users");

echo "<table border='1'>
<tr>
<th>User ID</th>
<th>UserName</th>
<th>Email</th>
<th>Info</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['userID'] . "</td>";
echo "<td>" . $row['username'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['info'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($con);
  
  
  ?>
  </p>
 
  
  </div>
    </div>


</div>

<?php 
require('layout/footer.php'); 
?>