<?php
//start the session each time
ob_start();
session_start();
//connecting to my database
require_once 'databaseconnect.php';
//checking if the user is already logged in and if not redirecting to userlogin.php
 if( !isset($_SESSION['user']) ) {
  header("Location: userlogin.php");
  exit;
 }
//this is where the user information is taken from
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
//including my design patterns file
include_once 'designpatterns.php';
$greeter = $userRow['userName'];
$g = Greeter::create('Welcome ' . $greeter);
$gr = $g->getGreeting(); 
$a = new decorate;
//connecting to my afs directory
$target_dir = "/afs/cad.njit.edu/u/g/e/ge45/public_html/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//uploading the file if the submit button is clicked and checking if it is an image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
//checking if the file already exists in the directory
if (file_exists($target_file)) {
    echo "Please change the name of your file.";
    $uploadOk = 0;
}
//checking the size of the file
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Your file is too large.";
    $uploadOk = 0;
}
//checking the file type
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "This file type is not allowed. Only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
//checking if the file was uploaded
if ($uploadOk == 0) {
    echo "Error. Your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "There was an error uploading your file.";
    }
}
//ending the php and starting the html
?>

<html>
<body>
<link rel="stylesheet" href="yankeescss.css">
<a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a>
<h1><b>New York Yankees Fan Website</b></h1>
<h2><?php echo $a->greet($gr)?></h2>
<h3>Profile Picture</h3>

<img class="profile-photo" align="middle" src=<?php echo basename( $_FILES["fileToUpload"]["name"]); ?> />

<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<h3>About <?php echo $greeter?></h3>

<ul>
<li>Name: <?php echo $userRow['userNames']?></li>
<li>Favorite Baseball Player: <?php echo $userRow['userPlayer']?></li>
</ul> 


<h2>News</h2>
<h3>Yankees Sign Aroldis Chapman for 5 years!</h3>
<a href="http://www.foxsports.com/mlb/story/new-york-yankees-aroldis-chapman-chicago-cubs-sign-free-agency-120716">Yankees sign Aroldis Chapman to a massive five-year deal</a>
<h3>Top 30 Prospects for the New York Yankees.</h3>
<a href="http://m.mlb.com/prospects/2016?list=nyy">Top 30 Yankees Prospects</a>
</body>
</html>
<?php ob_end_flush(); ?>
