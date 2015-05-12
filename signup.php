<?php
include_once("phpIncludes/check_login_status.php");?>

<?php
if(!isset($_SESSION))
{
session_start();
}  
// If user is logged in, header them away
if(isset($_SESSION["username"])){
header("location: message.php?msg=You are already logged in");
    exit();
}
?>
<?php
if(isset($_POST["usernamecheck"]))
{
	include_once("phpIncludes/dbConx.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
	$query = mysqli_query($dbConx, $sql);
	$uname_check = mysqli_num_rows($query);
	
	if (strlen($username) < 3 || strlen($username) > 16) 
	{
   echo '<strong style="color:#F00;">Username should be 3 - 16 characters long</strong>';
   exit();
    }
   if (is_numeric($username[0])) 
    {
   echo '<strong style="color:#F00;">Usernames should begin with a letter    </strong>';
   exit();
    }
    if ($uname_check < 1) {
   echo '<strong style="color:#009900;">Nice username</strong>';
   exit();
    } else {
   echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
   exit();
    }
}
?>
<?php 
 if(isset($_POST["u"])){
// CONNECT TO THE DATABASE
include_once("phpIncludes/dbConx.php");
// GATHER THE POSTED DATA INTO LOCAL VARIABLES
$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
$e = mysqli_real_escape_string($dbConx, $_POST['e']);
$p = $_POST['p'];
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($dbConx, $sql); 
$u_check = mysqli_num_rows($query);
// -------------------------------------------
$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($dbConx, $sql); 
$e_check = mysqli_num_rows($query);
// FORM DATA ERROR HANDLING
if($u == "" || $e == "" || $p == ""){
echo "The form submission is missing values.";
        exit();
} else if ($u_check > 0){ 
        echo "The username you entered is alreay taken";
        exit();
} else if ($e_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
} else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
///// END FORM DATA ERROR HANDLING
// Begin Insertion of data into the database
// Hash the password and apply your own mysterious unique salt

//$cryptpass = crypt($p);
//include_once ("phpIncludes/randStrGen.php");
//$p_hash = randStrGen(20)."$cryptpass".randStrGen(20);
$p_hash = md5($p);

// Add user info into the database table for the main site table
$sql = "INSERT INTO users (username, email, password, ip)       
       VALUES('$u','$e','$p_hash','$ip')";
$query = mysqli_query($dbConx, $sql); 
$uid = mysqli_insert_id($dbConx);

/////////////////////////////////////////////////////////////
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["e"])){
$p = md5($_POST['p']);
// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
// FORM DATA ERROR HANDLING
if($e == "" || $p == ""){
echo "login_failed";
        exit();
} else {
// END FORM DATA ERROR HANDLING
$sql = "SELECT id, username, password FROM users WHERE email='$e'";
        $query = mysqli_query($dbConx, $sql);
        $row = mysqli_fetch_row($query);
$db_id = $row[0];
$db_username = $row[1];
        $db_pass_str = $row[2];
if($p != $db_pass_str){
echo "login_failed";
            exit();
} else {
// CREATE THEIR SESSIONS AND COOKIES
$_SESSION['userid'] = $db_id;
$_SESSION['username'] = $db_username;
$_SESSION['password'] = $db_pass_str;
setcookie("id", $db_id, strtotime( '+60 days' ), "/", "", "", TRUE);
setcookie("user", $db_username, strtotime( '+60 days' ), "/", "", "", TRUE);
    setcookie("pass", $db_pass_str, strtotime( '+60 days' ), "/", "", "", TRUE); 
// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
$sql = "UPDATE users SET ip='$ip' WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($dbConx, $sql);


echo 7;
exit();
}
}
}
}
exit();
}
?>
