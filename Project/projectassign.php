<!--
Created by Ivan Zhang on 3/25/2020 
CIS 484 New Project
I have given or received any unauthorizated assistance on this assignment.

-->

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
else{
// Include config file
require_once "config.php";

$sql = "SELECT * FROM Project";

$result = mysqli_query($link, $sql);

$sql1 = "SELECT * FROM User";

$result1 = mysqli_query($link, $sql1);

//if(isset($_POST['submit'])){

//$project  = $_POST['projectList'];
//}

   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ivan Zhang</title>

<!-- Bootstrap v4 -->
<link href="css/mybootstrap.css" rel="stylesheet" type="text/css" media="screen">


<link href="css/custom.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body class="bg-black">
<header>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light "> 
    <img src="images/logo.png" alt="logo" id = "navlogo">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-center" id="navbarNav" >
    <ul class="navbar-nav">
      <li class="nav-item ">
        <a class="nav-link" href="home.html">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
                <a class="nav-link" href="myaccount.php">My Account</a>
            </li>
      <li class="nav-item">
        <a class="nav-link" href="box.php">Devices</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="addbox.php">Add Devices</a>
      </li>
       <li class="nav-item dropdown active">
        <a class="nav-link dropdown align-bottom" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Projects
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="projectassign.php">Assign Projects</a>
          <a class="dropdown-item" href="project.php">View Projects</a>
          <a class="dropdown-item" href="createproject.php">Create Projects</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown align-bottom" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Observations</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">My Observation</a>
          <a class="dropdown-item" href="addobservation.php">Create Observation</a>
          <a class="dropdown-item" href="#">Edit Observation</a>
        </div>
      </li>  
      <li class="nav-item">
         <a class="nav-link" href="logout.php" tabindex="-1" aria-disabled="true">Logout</a>
      </li>
    </ul>
  </div>
</nav>
</header>
<br/><br/><br/>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="jumbotron" align="center">
        <h1>Project Assignment</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="justify-content-center">
        <select name = "projectList">
            <?php if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "<option value =".htmlspecialchars($row[ProjectID]).">".htmlspecialchars($row[Title])."</option>";
                }
            }
            else {
                echo "Zero Results";
                
            }
            
            ?> 
        </select>
        <input type="submit" name="someAction" value="Add User"/>
        <?php
        require_once "config.php";
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['someAction']))
        {
        $project  = $_POST['projectList'];
        $param_id = $_SESSION["id"];
        
        $update = "update user set ProjectID = ? where UserID = ?";
     
        $stmt1 = mysqli_prepare($link, $update);
        mysqli_stmt_bind_param($stmt1, 'ii', $project, $param_id);
        if (mysqli_stmt_execute($stmt1))
        {
            echo "Project successfully assigned to user";
        }
        else {
            echo "Project not successfully assigned to user ";
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);           
        }
        mysqli_stmt_close($stmt1);
        
        
        }
        ?>
        <input type="submit" name="remove" value="Remove User"/>
        <?php
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['remove']))
        {
        
        $param_id = $_SESSION["id"];
        
        $update1 = "update User set ProjectID = NULL where UserID = ? and ProjectID is not NULL";
     
        $stmt2 = mysqli_prepare($link, $update1);
        mysqli_stmt_bind_param($stmt2, 'i', $param_id);
        if (mysqli_stmt_execute($stmt2))
        {
            echo "Project successfully removed from user";
        }
        else 
        {
            echo "Project not successfully removed from user";
            echo mysqli_stmt_error($stmt2);
        }
        mysqli_stmt_close($stmt2);
        mysqli_close($link);
        }
        ?>
        </form>           
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="jumbotron" align="center">
        <h1>Users Table</h1>
        <div class="table-responsive-sm">
          <table class="table table-bordered table-dark table-sm">
              <tr class="header">
              <th class="text-center">UserID</th>
              <th class="text-center">Username</th>
              <th class="text-center">FirstName</th>
              <th class="text-center">LastName</th>
              <th class="text-center">Email</th>
              <th class="text-center">Phone</th>
              <th class="text-center">Status</th>
              <th class="text-center">Type</th>
              <th class="text-center">LastUpdated</th>
              <th class="text-center">LastUpdatedBy</th>
              <th class="text-center">ProjectID</th>
            </tr>
            <?php if (mysqli_num_rows($result1) > 0) {
            // output data of each row
            
            while($row = mysqli_fetch_assoc($result1)) {
                echo "<tr>";
                echo "<td class=text-center>".htmlspecialchars($row[UserID])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[Username])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[FirstName])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[LastName])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[Email])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[Phone])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[Status])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[Type])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[LastUpdated])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[LastUpdatedBy])."</td>";
                echo "<td class=text-center>".htmlspecialchars($row[ProjectID])."</td>";
                echo "</tr>";
                }
            }
            else {
                echo "Zero Results";
            }
            mysqli_close($link);?>           
          </table>
        </div> 
                 
      </div>
    </div>
  </div>
</div>



<!-- jQuery and Bootstrap links - do not delete! -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   
</body>
</html>