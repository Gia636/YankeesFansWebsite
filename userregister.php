<?php
  ob_start();
  session_start();
include_once 'databaseconnect.php';
if( isset($_SESSION['user'])!="" ){
    header("Location: YankeesFans.php");}
$error = false;
if ( isset($_POST['btn-signup']) ) {

  $username = trim($_POST['username']);
  $username = strip_tags($username);
  $username = htmlspecialchars($username);

  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);

  $player = trim($_POST['player']);
  $player = strip_tags($player);
  $player = htmlspecialchars($player);

  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $password = trim($_POST['password']);
  $password = strip_tags($password);
  $password = htmlspecialchars($password);

  $confirmpassword = trim($_POST['confirmpassword']);
  $confirmpassword = strip_tags($confirmpassword);
  $confirmpassword = htmlspecialchars($confirmpassword);

  if (empty($username)) {
   $error = true;
   $userError = "Please enter a username.";
} 
   else if (strlen($username) < 5) {
   $error = true;
   $userError = "Your username must have at least 5 characters.";
} 
   else if (!preg_match("/^[a-zA-Z0-9]+$/",$username)) {
   $error = true;
   $userError = "Username may only contain letters and numbers.";
}
 else {

   $query = "SELECT userName FROM users WHERE userName='$username'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $userError = "This username is already taken.";
   }
  }

  if (empty($name)) {
   $error = true;
   $nameError = "Please enter your full name.";
} 
   else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Your name must have at least 3 characters.";
} 
   else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = true;
   $nameError = "Name may only contain letters.";
}
 else {

   $query = "SELECT userNames FROM users WHERE name='$name'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   
  }

  if (empty($player)) {
   $error = true;
   $playerError = "Please enter a favorite player.";
} 
   else if (strlen($player) < 3) {
   $error = true;
   $playerError = "Player name must have at least 3 characters.";
} 
   else if (!preg_match("/^[a-zA-Z ]+$/",$player)) {
   $error = true;
   $playerError = "Player name may only contain letters.";
}
 else {

   $query = "SELECT userPlayer FROM users WHERE userPlayer='$player'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);

  }
 
   
if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "This is not a valid email address.";
} 
   else {

   $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
   $result = mysql_query($query);
   $count = mysql_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = "Email is already in use.";
   }
  }

  if (empty($password)){
   $error = true;
   $passError = "Please enter a password.";
  } else if(strlen($password) < 8) {
   $error = true;
   $passError = "Password must have at least 8 characters.";
  }
$encryptedpassword = hash('sha256', $password);
  
   if ($_POST['password'] != $_POST['confirmpassword']){
    $error = true;
    $nomatch = "Passwords do not match.";
}
if( !$error ) {
   $query = "INSERT INTO users(userName,userEmail,userPass,userNames,userPlayer) VALUES('$username','$email','$encryptedpassword','$name','$player')";
   $registered = mysql_query($query);
    
   if ($registered) {
    $errorType = "success";
    $errorMessage = "You are now registered. You can now login to access your profile.";
    unset($username);
    unset($email);
    unset($password);
    unset($confirmpassword);
    unset($player);
    unset($name);
} 
    else {
    $errorType = "danger";
    $errorMessage = "Something went wrong, please try again later..."; 
  }
 }
}
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
             <h2 class="">Sign Up</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errorMessage) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errorType=="success") ? "success" : $errorType; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errorMessage; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="username" class="form-control" placeholder="Enter Username" maxlength="50" value="<?php echo $username ?>" />
                </div>
                <span class="text-danger"><?php echo $userError; ?></span>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="name" class="form-control" placeholder="Enter Full Name" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="player" class="form-control" placeholder="Enter Favorite Player" maxlength="50" value="<?php echo $player ?>" />
                </div>
                <span class="text-danger"><?php echo $playerError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Enter Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="password" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
             <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $nomatch; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <a href="userlogin.php">Click here to sign in.</a>
            </div>
        
        </div>
   
    </form>
    </div> 

</div>

</body>
</html>
<?php ob_end_flush(); ?>