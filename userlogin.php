<?php
//staring the session
  ob_start();
  session_start();
  require_once 'databaseconnect.php';
//if the user is already logged in go to the profile
if ( isset($_SESSION['user'])!="" ) {
  header("Location: YankeesFans.php");
  exit;
 }
 
 $error = false;
 //if the login button is clicked...
 if( isset($_POST['btn-login']) ) { 

  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
//check if email is entered and valid  
  if(empty($email)){
   $error = true;
   $emailError = "You need to enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "This is not a valid email address.";
  }
 //check if password is entered 
  if(empty($pass)){
   $error = true;
   $passError = "You need to enter your password.";
  }
  
  if (!$error) {
//check password against hashed password in database   
   $password = hash('sha256', $pass);
//this is where the data is taken from in the database  
   $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
   $row=mysql_fetch_array($res);
   $count = mysql_num_rows($res);
//checking login information   
   if( $count == 1 && $row['userPass']==$password ) {
    $_SESSION['user'] = $row['userId'];
    header("Location: YankeesFans.php");
   } else {
    $errMSG = "Email or password is incorrect.";
   }
    
  }
  
 }
//ending php and starting html
?>
<!DOCTYPE html>
<html>

<body>
<link rel="stylesheet" href="yankeescss.css">
<h1><b>New York Yankees Fan Website</b></h1>
<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class="">Sign In</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <a href="userregister.php">Click here to sign up</a>
            </div>
        
        </div>
   
    </form>
    </div> 

</div>

</body>
</html>
<?php ob_end_flush(); ?>
