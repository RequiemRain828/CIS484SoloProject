<!--
Created by Ivan Zhang on 3/25/2020 
CIS 484 New Project
I have given or received any unauthorizated assistance on this assignment.

-->

<?php
// Include config file
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
else
{
  require_once "config.php";
  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){
                 
  // Prepare an insert statement
  $sql = "INSERT INTO BOX (BoxName, BatteryStatus, AnimalStatus, Active, UserID) VALUES (?, ?, ?, ?, ?)";
          
  if($stmt = mysqli_prepare($link, $sql)){
  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "ssssi", $boxname, $battery, $status, $active, $param_id);
              
  // Set parameters
  $param_id = $_SESSION["id"];
  $boxname = $_POST['boxname'];
  $battery = $_POST['battery'];
  $status = $_POST['status'];
  $active = $_POST['active'];              
              
  
    }
    
  }

} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ivan Zhang</title>

<!-- Bootstrap v4 -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link href="css/custom.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<header>

<!-- INSERT HTML PAGE CONTENT HERE -->
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light "> 
    <img src="images/logo.png" alt="logo" id = "navlogo">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-center" id="navbarNav" >
    <ul class="navbar-nav">
      <li class="nav-item active">
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
       <li class="nav-item dropdown">
        <a class="nav-link dropdown align-bottom" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Projects
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="projectassign.php">My Projects</a>
          <a class="dropdown-item" href="project.php">My Projects</a>
          <a class="dropdown-item" href="createproject.php">Create Projects</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown align-bottom" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Observations</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="observation.php">My Observation</a>
          <a class="dropdown-item" href="addobservation.php">Create Observation</a>
          <a class="dropdown-item" href="edit.php">Edit Observation</a>
        </div>
      </li> 
      <li class="nav-item">
         <a class="nav-link" href="logout.php" tabindex="-1" aria-disabled="true">Logout</a>
      </li>
    </ul>
  </div>
</nav>

</header>

<body class="bg-black">

<div class="container d-flex h-100">
  <div class="row align-self-center w-100">
    <div class="col-sm-6 mx-auto">
      <div class="jumbotron" align="center">
        <h2 class="text-center" id="title">
            <img src="images/logocrop.png" alt="logocopy" runat="server" class="logobrand" />
        </h2>
        <h1 class="text-orange">Create Project: </h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="justify-content-center">
            <p>Please complete form to create a project.</p>
            <div class="container-fluid">
              <div class="row">
                <div class ="col-sm-6">
                  <div class="form-group">
                    <input type="text" name="boxname" class="form-control" placeholder="Boxname" id="boxname">
                  </div>    
                  <div class="form-group">
                    <input type="text" name="battery" class="form-control" placeholder="BatteryStatus" id="battery">            
                  </div>
                </div>
                <div class ="col-sm-6">
                  <div class="form-group">
                    <input type="text" name="status" class="form-control" placeholder="Status" id="status">
                  </div>    
                  <div class="form-group">
                    <input type="text" name="active" class="form-control" placeholder="Active" id="active">            
                  </div>
                </div>
              </div>
            </div>
            <?php 
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                        
            } 
            else{
              echo "Failure";
              }
            // Close statement
            mysqli_stmt_close($stmt);

            // Close connection
            mysqli_close($link);
            ?>
            <div class="form-group">
              <button type="submit" class="btn btn-green form-control text-white lead">Create Project</button>
            </div>
            <div class="form-group">
                <input type="submit" value="Populate" onclick="populate(); return false;" 
                class="btn btn-success form-control text-white form-control" formnovalidate>
            </div>
        </form> 
      </div>
    </div>
  </div>
</div>
<script>
function populate() {
  document.getElementById("boxname").value = "Box1";
  document.getElementById("battery").value = "80";
  document.getElementById("status").value = "Healthy";
  document.getElementById("active").value = "Yes";
}
</script>
<!-- jQuery and Bootstrap links - do not delete! -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!-- end of do not delete -->
</body>

</html>