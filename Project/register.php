<!--
Created by Ivan Zhang on 3/25/2020 
CIS 484 New Project
I have given or received any unauthorizated assistance on this assignment.

-->

<?php
// Include config file
require_once "config.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: myaccount.php");
  exit;
}
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$userid = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT UserID FROM user WHERE Username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
               
        // Prepare an insert statement
        $sql = "INSERT INTO User (Username, FirstName, LastName, Email, Phone, Status, Type, LastUpdated, LastUpdatedBy) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        
        $sql2 = "INSERT INTO Credential (UserID, Username, PasswordPhrase) Values (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_username, $first_name, $last_name, $email, $phone, $status, $type, $last_updated_by);
            
            // Set parameters
            $param_username = $username;
            $first_name = $_POST['firstname'];
            $last_name = $_POST['lastname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];  
            $status = $_POST['status'];
            $type = $_POST['type'];
            $last_updated = NULL;
            $last_updated_by = "Ivan Zhang";              
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $userid = mysqli_insert_id($link);
                $sucess = "Account was created successfully";
                
            } else{
                $failure = "Account. Please try again.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        if($stmt2 = mysqli_prepare($link, $sql2)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "sss", $userid, $param_username, $param_password);

            // Set parameters
            $param_username = $username;
                     
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            if(mysqli_stmt_execute($stmt2)){
                // Redirect to login page
                $sucess = "Account was created successfully";
                header("location: login.php");
            } else{
                $failure = "Account. Please try again." . mysqli_stmt_error($stmt2);
            }            
            // Close statement
            mysqli_stmt_close($stmt2);

        }      
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Animetrics</title>

<!-- Bootstrap v4 -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link href="css/custom.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body class="bg-black">
<header>  
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light"> 
    <img src="images/logo.png" alt="logo" id = "navlogo">

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-center" id="navbarNav" >
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
      </li>
       <li class="nav-item active">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="login.php" tabindex="-1" aria-disabled="true">Login</a>
      </li>
    </ul>
  </div>
</nav> 

</header> 
<div class="container h-25">
</div>
<br/>
<br/>
<br/>

<div class="container d-flex h-100">
  <div class="row align-self-center w-100 ">
    <div class="col-sm-6 col-xs-6 mx-auto">
      <div class="jumbotron" align="center">
        <h2 class="text-center" id="title">
            <img src="images/logocrop.png" alt="logocopy" runat="server" class="logobrand" />
        </h2>
        <h1 class="text-orange">Register: </h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="justify-content-center">
        
          <p>Please fill this form to create an account.</p>
          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" id="username" placeholder="Username" required>
            <span class="help-block"><?php echo $username_err; ?></span>
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" id="password" placeholder="Password">
            <span class="help-block"><?php echo $password_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" id="confirmpassword" placeholder="Confirm Password">
             <span class="help-block"><?php echo $confirm_password_err; ?></span>
          </div>
          <div class="form-row">
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname">
              </div>
            </div>
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname">
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" name="email" id="email">
              </div>
            </div>
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Phone(xxx-xxx-xxxx)" name="phone" id="phone">
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">                
                <select class="form-control" name="status">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6 col-xs-6">
              <div class="form-group">               
                <select class="form-control" name="type">
                  <option value="BoxOwner">BoxOwner</option>
                  <option value="TeamMember">TeamMember</option>
                  <option value="Admin">Admin</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success form-control text-white lead form-control">Register</button>
          </div>
          <div class="form-group">
            <input type="submit" value="Populate" onclick="populate(); return false;" 
            class="btn btn-success form-control text-white form-control" formnovalidate>
          </div>
          <p>Already have an account? <a href="login.php">Login here</a>.</p>         
        </form> 
      </div>
    </div>
  </div>
</div>

<script>
function populate() {
  document.getElementById("username").value = "MengHao";
  document.getElementById("password").value = "black828";
  document.getElementById("confirmpassword").value = "black828";
  document.getElementById("firstname").value = "Ivan";
  document.getElementById("lastname").value = "Zhang";
  document.getElementById("email").value = "requiemrain828@gmail.com";
  document.getElementById("password").value = "black828";
  document.getElementById("phone").value = "540-209-7325";
}
</script>
<!-- jQuery and Bootstrap links - do not delete! -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!-- end of do not delete -->    
</body>
</html>