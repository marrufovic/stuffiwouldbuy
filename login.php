<?php
include_once("phpIncludes/check_login_status.php");
// If user is already logged in, header away
//index.php?u=".$_SESSION["username"]
//javascript: "user.php?u="+ajax.responseText;
if($user_ok == true){
header("location: index.php?u=".$_SESSION["username"]);
    exit();
}
?>
<?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["e"])){
// CONNECT TO THE DATABASE
include_once("phpIncludes/dbConx.php");
// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
$e = mysqli_real_escape_string($dbConx, $_POST['e']);
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
echo $db_username;
   exit();
}
}
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Log In</title>
<link rel="icon" href="images/favicon.png" type="imgage/png">
<link rel="stylesheet" href="style/style.css">
<style type="text/css">
#login{
	float:left;
	margin-top:24px;
	margin-left:150px;	
}
#loginform{
}
#loginform > div {
margin-top: 12px;	
}
h3
{
margin-left:50px;
color:#666666;
}
#loginform > input {
width: 200px;
padding: 3px;
background:#CCC;
}
#loginbtn {
font-size:15px;
padding: 10px;
}
</style>

<style type="text/css">
  #signup
  {
	  float:right;
	  margin-top:24px;
	  margin-right:150px;
  }
  #signupform
  {
  }
  #signupform > div
  {
	  margin-top:0px;
  }
  h3
  {
	  margin-left:50px;
	  color:#666666;
  }
  #signupform > input 
  {
	  width:200px;
	  padding:3px;
	  background:#CCC;
  }
  #signupbtn
  {
	  font-size:15px;
	  padding:10px;
  }
  
  #or{
	  float:left;
	  width:30px;
	  margin-left:90px;
	  margin-right:auto;
	  color:#666666;
  }
  #between{
   height:200px; 
   width:220px; 
   float:left; 
   margin-top:100px; 
   margin-left:20px;
   text-align:center; 
  }
  #instruction{
	  width:220px;
	  height:50px;
	  margin-top:100px;
  }
  </style>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script>
function emptyElement(x){
_(x).innerHTML = "";
}
function login(){
var e = _("email").value;
var p = _("password").value;
if(e == "" || p == ""){
_("status").innerHTML = "Fill out all of the form data";
} else {
_("loginbtn").style.display = "none";
_("status").innerHTML = 'please wait ...';
var ajax = ajaxObj("POST", "login.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           if(ajax.responseText == "login_failed"){
_("status").innerHTML = "Login unsuccessful, please try again.";
_("loginbtn").style.display = "block";
} else {
window.location = "index.php?u="+ajax.responseText;
}
       }
        }
        ajax.send("e="+e+"&p="+p);
}
}



function restrict(elem){
var tf = _(elem);
var rx = new RegExp;
if(elem == "email2"){
rx = /[' "]/gi;
} else if(elem == "username"){
rx = /[^a-z0-9]/gi;
}
tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
_(x).innerHTML = "";
}
function checkusername(){
var u = _("username").value;
if(u != ""){
_("unamestatus").innerHTML = 'checking ...';
var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           _("unamestatus").innerHTML = ajax.responseText;
       }
        }
        ajax.send("usernamecheck="+u);
}
}
function signup(){
var u = _("username").value;
var e = _("email2").value;
var p1 = _("pass1").value;
var p2 = _("pass2").value;
var status = _("status");
if(u == "" || e == "" || p1 == "" || p2 == ""){
status.innerHTML = "Fill out all of the form data";
} else if(p1 != p2){
status.innerHTML = "Your password fields do not match";
} else {
_("signupbtn").style.display = "none";
status.innerHTML = 'please wait ...';
var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           if(ajax.responseText != 7){
status.innerHTML = ajax.responseText;
_("signupbtn").style.display = "block";
alert(ajax.responseText);
} else {
window.location = "index.php?u="+u;
}
       }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1);
}
}

</script>
</head>
<body>
<?php include_once("pageTop.php"); ?>
<div id="shadow">
<div id="pageMiddle" style="border-bottom:solid 1px #CCC;">
<div style="height:350px;">
  <div id="login">
  <h3 style="color:#14ABCC;">Log In</h3>
  <!-- LOGIN FORM -->
  <form id="loginform" onsubmit="return false;">
    <div>Email Address:</div>
    <input type="text" id="email" onfocus="emptyElement('status')" maxlength="88">
    <div>Password:</div>
    <input type="password" id="password" onfocus="emptyElement('status')" maxlength="100">
    <br /><br />
    <button id="loginbtn" onclick="login()">Log In</button> 
  </form>
  </div>
  <!-- LOGIN FORM -->
  <div id="between"><div id="or"><h4>OR</h4></div><div id="instruction"><p id="status"></p><span id="unamestatus"></span></div></div>
  <div id="signup">
  <h3 style="color:#14ABCC;">Sign Up</h3>
  <form name="signupform" id="signupform" onSubmit="return false;">
  <div>Username: </div>
  <input id="username" type="text" onBlur="checkusername()" onKeyUp="restrict('username')" maxlength="16"> 
  <div>Email Address: </div>
  <input id="email2" type="text" onFocus="emptyElement('status')" onKeyUp="restrict('email')" maxlength="50">
  <div>Create Password: </div>
  <input id="pass1" type="password" onFocus="emptyElement('status')" maxlength="100">
  <div>Confirm Password: </div>
  <input id="pass2" type="password" onFocus="emptyElement('status')" maxlength="100">
  <br /><br />
  <button id="signupbtn" onClick="signup()">Create Account</button>
  </form>
  </div>
      </div>
</div>
</div>
<?php include_once("pageBottom.php"); ?>
</body>
</html>
