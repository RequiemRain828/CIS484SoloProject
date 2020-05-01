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
  
  $sql = "SELECT * FROM Observation";

  $result = mysqli_query($link, $sql);               
  
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
      <li class="nav-item">
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
<br/><br/><br/>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="jumbotron" align="center">
        <h2 class="text-center" id="title">
            
        </h2>
        <h1 class="text-orange">Observations Table </h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="justify-content-center">
            
            <div class="table-responsive-sm">
            <table class="table table-bordered table-dark table-sm">
              <tr>
                <th>ID</th>
                <th>Genus</th>
                <th>Species</th>
                <th>Size</th>
                <th>Weight</th>
                <th>Temperature</th>
                <th>Humidity</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>TotalTime</th>
                <th>LastUpdated</th>
                <th>LastUpdatedBy</th>
                <th>ProjectID</th>
                <th>BoxID</th>
              </tr>
              <?php 
              if (mysqli_num_rows($result) > 0) {

                while($row = mysqli_fetch_assoc($result))
                {
                  echo "<tr>";
                  echo "<td class=text-center>".htmlspecialchars($row[ObservationNumber])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[Genus])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[Species])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[Size])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[Weight])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[Temperature])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[Humidity])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[ArrivalDayTime])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[DepartureDayTime])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[TotalTime])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[LastUpdated])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[LastUpdatedBy])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[ProjectID])."</td>";
                  echo "<td class=text-center>".htmlspecialchars($row[BoxSerialNumber])."</td>";
                  echo "</tr>";
                }
              }
              else {
                  echo "Zero Results";
              }
              
              mysqli_close($link);
              ?>
            </table>
            <div>
        </form> 
      </div>
    </div>
  </div>
</div>

<!-- jQuery and Bootstrap links - do not delete! -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!-- end of do not delete -->
</body>

</html>