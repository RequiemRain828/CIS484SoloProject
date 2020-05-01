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
  $sql1 = "SELECT * FROM Project";

  $result = mysqli_query($link, $sql1);

  $sql2 = "SELECT * FROM Box";

  $result1 = mysqli_query($link, $sql2);
  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['insert'])){
                 
  // Prepare an insert statement
  $sql = "INSERT INTO observation (Genus, Species, Size, Weight, Temperature, Humidity, ArrivalDayTime, DepartureDayTime, TotalTime, LastUpdated, LastUpdatedBy, ProjectID, BoxSerialNumber) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)";
          
  $stmt = mysqli_prepare($link, $sql);
  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "ssssssssdsii", $genus, $species, $size, $weight, $temperature, $humidity, $arrival, $departure, $days, $last_updated_by, $project, $box);
              
  // Set parameters
  $genus = $_POST['genus'];
  $size = $_POST['size'];
  $weight = $_POST['weight'];
  $species = $_POST['species'];
  $temperature = $_POST['temperature'];
  $humidity = $_POST['humidity'];
  $arrival = ($_POST['arrival']);
  $departure = ($_POST['departure']);
  $project = ($_POST['projectList']);
  $box = ($_POST['boxList']);
  $arrcal = date_create(substr($arrival, 0, 10));
  $depcal = date_create(substr($departure, 0, 10));
  $total = date_diff($arrcal, $depcal);
  $days = $total->days;
  

  $last_updated_by = "Ivan Zhang";              
              
  
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
       <li class="nav-item dropdown">
        <a class="nav-link dropdown align-bottom" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Projects
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="projectassign.php">Assign Projects</a>
          <a class="dropdown-item" href="project.php">View Projects</a>
          <a class="dropdown-item" href="createproject.php">Create Projects</a>
        </div>
      </li>
      <li class="nav-item dropdown active">
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
    <div class="col-sm-8 mx-auto">
      <div class="jumbotron" align="center">
        <h2 class="text-center" id="title">
            <img src="images/logocrop.png" alt="logocopy" runat="server" class="logobrand" />
        </h2>
        <h1 class="text-orange">Create Observation: </h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="justify-content-center">
            <p>Please complete form to create a observation.</p>
        <div class="form-row">
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Genus" name="genus" id="genus">
              </div>
            </div>
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Species" name="species" id="species">
              </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Size" name="size" id="size">
              </div>
            </div>
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Weight" name="weight" id="weight">
              </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Temperature" name="temperature" id="temperature">
              </div>
            </div>
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Humidity" name="humidity" id="humidity">
              </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="datetime-local" class="form-control" placeholder="Arrival Day Time" name="arrival" id="arrival" value="2017-06-01T08:30">
              </div>
            </div>
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="datetime-local" class="form-control" placeholder="Departure Day Time" name="departure" id="departure" value="2017-06-01T09:30">
              </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-6 col-xs-6 form-group">
              <select name = "projectList" class="form-control">
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
            </div>
            <div class="col-sm-6 col-xs-6 form-group">
              <select name = "boxList" class="form-control">
              <?php if (mysqli_num_rows($result1) > 0) {
              // output data of each row
              while($row1 = mysqli_fetch_assoc($result1)) {
                  echo "<option value =".htmlspecialchars($row1[BoxSerialNumber]).">".htmlspecialchars($row1[BoxName])."</option>";
                  }
              }
              else {
                  echo "Zero Results";
                  
              }
              ?> 
              </select>
            </div>
        </div>         
        
        <?php 
        // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
          
                        
          } 
          else{
            echo "Failure". mysqli_stmt_error($stmt);
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);  
            }
        // Close statement
        //mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
        ?>
        <div class="form-group">
          <button type="submit" class="btn btn-green form-control text-white lead" name="insert">Create Project</button>
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
  document.getElementById("genus").value = "Saint Island shrew";
  document.getElementById("species").value = "Sorex Arizonae";
  document.getElementById("size").value = 56.55;
  document.getElementById("weight").value = 56;
  document.getElementById("temperature").value = 56.55;
  document.getElementById("humidity").value = 56.55;
  document.getElementById("arrival").value = "2017-06-01T08:30";
  document.getElementById("departure").value = "2017-06-02T09:30";
}

</script>
<!-- jQuery and Bootstrap links - do not delete! -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!-- end of do not delete -->
</body>

</html>