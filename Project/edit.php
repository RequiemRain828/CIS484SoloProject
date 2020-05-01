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
  $sql2 = "SELECT * FROM Observation";

  $result = mysqli_query($link, $sql2); 
  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['search'])){
                 
  // Prepare an insert statement
  $valueToSearch = "%{$_POST['valueToSearch']}%";
  $sql = "Select * from Observation WHERE Species LIKE ?";
  
          
  $stmt = mysqli_prepare($link, $sql);
  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "s", $valueToSearch);
              
               
              
  
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
       <li class="nav-item dropdown ">
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
<br/>
<br/>
<div class="container-fluid h-100">
  <div class="row align-self-center">
    <div class="col-sm-12 mx-auto">
      <div class="jumbotron" align="center">
        <h2 class="text-center" id="title">
            
        </h2>
        <h1 class="text-orange">Search and Update Observation: </h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="justify-content-center">
            <p>Search And Update Observations</p>
            <div class="form-group">
              <input type="text" name="valueToSearch">
              <input type="submit" name="search" value="Search" class="btn btn-success">
            </div>
            <div class="table-responsive-sm">
            <table class="table table-bordered table-dark table-sm">
              <tr class="header">
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
              </tr>
              <?php
              
              if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $id, $result1, $result2, $result3, $result4, $result5, $result6, $result7, $result8,$result9, $result10, $result11, $result12, 
                  $result13);
                
                mysqli_stmt_fetch($stmt);
                $_SESSION["observationid"] = $id;
                if (mysqli_stmt_num_rows($stmt) > 0)
              {
                echo "<tr>";
                  echo '<td class="text-center">' .htmlspecialchars($id).'</td>';
                  echo '<td class="text-center form-group"><input class="form-control" type="text" value="'.htmlspecialchars($result1).'" name="genus"></td>';
                  echo '<td class="text-center form-group"><input class="form-control" type="text" value="'.htmlspecialchars($result2).'" name="species"></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result3).'" name="size"></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result4).'" name="weight"></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result5).'" name="temperature"></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result6).'" name="humidity"></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result7).'" name="arrival"></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result8).'" name="departure"></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result9).'" readonly></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result10).'" ></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result11).'" ></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result12).'" readonly></td>';
                  echo '<td class=text-center form-group><input class="form-control" type="text" value="'.htmlspecialchars($result13).'" readonly></td>';
                  echo "</tr>";
              }
              else
              {
                echo "Zero Results";
              } 
              } 
              else{
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
                  echo "Zero Results!";
              }
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);  
              }
              //mysqli_fetch_field($result)
              //(mysqli_stmt_fetch($stmt))
              //mysqli_stmt_close($stmt);       
              
              ?>
              <?php

              if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['update'])){
              $sql1 = "Update Observation SET GENUS = ?, SPECIES = ?, Size = ?, Weight = ?, Temperature = ?, Humidity = ?, ArrivalDayTime = ?, DepartureDayTime = ?, TotalTime =?, LastUpdated = NOW() WHERE ObservationNumber = ?";
              $stmt1 = mysqli_prepare($link, $sql1);
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt1, "ssssssssdi", $genus, $species, $size, $weight, $temperature, $humidity, $arrival, $departure, $days, $_SESSION["observationid"]);
              // Set parameters
              $genus = $_POST['genus'];
              $size = $_POST['size'];
              $weight = $_POST['weight'];
              $species = $_POST['species'];
              $temperature = $_POST['temperature'];
              $humidity = $_POST['humidity'];
              $arrival = ($_POST['arrival']);
              $departure = ($_POST['departure']);
              $arrcal = date_create(substr($arrival, 0, 10));
              $depcal = date_create(substr($departure, 0, 10));
              $total = date_diff($arrcal, $depcal);
              $days = $total->days;
              //$total = date_diff($arrival, $departure);
              $last_updated_by = "Ivan Zhang"; 
              if (mysqli_stmt_execute($stmt1))
              {
                echo "Successfully updated ID# ".htmlspecialchars($_SESSION["observationid"]);
              }
              else 
              {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL); 
              }

              //mysqli_stmt_close($stmt1);
              }

              mysqli_close($link);
              ?>
            </table>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <button type="submit" class="btn btn-success form-control text-white lead" name="update">Update</button>
              </div>
              <div class="form-group">
                  <input type="submit" value="Populate" onclick="populate(); return false;" class="btn btn-success form-control text-white form-control" formnovalidate>
              </div>
            </div>
        </form> 
      </div>
    </div>
  </div>
</div>
<script>
function populate() {
  document.getElementById("genus").value = "Saint Lawrence Island shrew";
  document.getElementById("species").value = "Sorex Arizonae";
  document.getElementById("size").value = 56.55;
  document.getElementById("weight").value = 56;
  document.getElementById("temperature").value = 56.55;
  document.getElementById("humidity").value = 56.55;
  document.getElementById("arrival").value = "2017-06-01T08:30";
  document.getElementById("departure").value = "2017-06-01T09:30";
}

</script>
<!-- jQuery and Bootstrap links - do not delete! -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!-- end of do not delete -->
</body>

</html>