<?php
// It is important for any file that includes this file, to have
// check_login_status.php included at its very top.

$loginLink = '<a href="login.php">Sign Up / Log In</a>';
if($user_ok == true) {
    $loginLink = '<a href="wishlist.php?u='.$log_username.'">Wish List </a>|<a href="logout.php"> Log Out</a>';
}
?>
<?php
$menu = '<label style="color:#CCC" onmousedown="chooseCategory(\'all\')">All</label> | 
      <label onmousedown="chooseCategory(\'tech\')">Tech</label> | 
      <label onmousedown="chooseCategory(\'funny\')">Funny</label> | 
      <label onmousedown="chooseCategory(\'useful\')">Useful</label> | 
      <label onmousedown="chooseCategory(\'fashion\')">Fashion</label> |      
      <label onmousedown="chooseCategory(\'him\')">Him</label> | 
      <label onmousedown="chooseCategory(\'her\')">Her</label> |
      <label onmousedown="chooseCategory(\'toys\')">Toys/Kids</label>';
if ($_SESSION['category'] == "tech")
{
	$menu = '<label onmousedown="chooseCategory(\'all\')">All</label> | 
      <label style="color:#CCC" onmousedown="chooseCategory(\'tech\')">Tech</label> | 
      <label onmousedown="chooseCategory(\'funny\')">Funny</label> | 
      <label onmousedown="chooseCategory(\'useful\')">Useful</label> | 
      <label onmousedown="chooseCategory(\'fashion\')">Fashion</label> |      
      <label onmousedown="chooseCategory(\'him\')">Him</label> | 
      <label onmousedown="chooseCategory(\'her\')">Her</label> |
      <label onmousedown="chooseCategory(\'toys\')">Toys/Kids</label>';
}
if ($_SESSION['category'] == "funny")
{
	$menu = '<label onmousedown="chooseCategory(\'all\')">All</label> | 
      <label onmousedown="chooseCategory(\'tech\')">Tech</label> | 
      <label style="color:#CCC" onmousedown="chooseCategory(\'funny\')">Funny</label> | 
      <label onmousedown="chooseCategory(\'useful\')">Useful</label> | 
      <label onmousedown="chooseCategory(\'fashion\')">Fashion</label> |      
      <label onmousedown="chooseCategory(\'him\')">Him</label> | 
      <label onmousedown="chooseCategory(\'her\')">Her</label> |
      <label onmousedown="chooseCategory(\'toys\')">Toys/Kids</label>';
}
if ($_SESSION['category'] == "useful")
{
	$menu = '<label onmousedown="chooseCategory(\'all\')">All</label> | 
      <label onmousedown="chooseCategory(\'tech\')">Tech</label> | 
      <label onmousedown="chooseCategory(\'funny\')">Funny</label> | 
      <label style="color:#CCC" onmousedown="chooseCategory(\'useful\')">Useful</label> | 
      <label onmousedown="chooseCategory(\'fashion\')">Fashion</label> |      
      <label onmousedown="chooseCategory(\'him\')">Him</label> | 
      <label onmousedown="chooseCategory(\'her\')">Her</label> |
      <label onmousedown="chooseCategory(\'toys\')">Toys/Kids</label>';
}
if ($_SESSION['category'] == "fashion")
{
	$menu = '<label onmousedown="chooseCategory(\'all\')">All</label> | 
      <label onmousedown="chooseCategory(\'tech\')">Tech</label> | 
      <label onmousedown="chooseCategory(\'funny\')">Funny</label> | 
      <label onmousedown="chooseCategory(\'useful\')">Useful</label> | 
      <label style="color:#CCC" onmousedown="chooseCategory(\'fashion\')">Fashion</label> |      
      <label onmousedown="chooseCategory(\'him\')">Him</label> | 
      <label onmousedown="chooseCategory(\'her\')">Her</label> |
      <label onmousedown="chooseCategory(\'toys\')">Toys/Kids</label>';
}
if ($_SESSION['category'] == "him")
{
	$menu = '<label onmousedown="chooseCategory(\'all\')">All</label> | 
      <label onmousedown="chooseCategory(\'tech\')">Tech</label> | 
      <label onmousedown="chooseCategory(\'funny\')">Funny</label> | 
      <label onmousedown="chooseCategory(\'useful\')">Useful</label> | 
      <label onmousedown="chooseCategory(\'fashion\')">Fashion</label> |      
      <label style="color:#CCC" onmousedown="chooseCategory(\'him\')">Him</label> | 
      <label onmousedown="chooseCategory(\'her\')">Her</label> |
      <label onmousedown="chooseCategory(\'toys\')">Toys/Kids</label>';
}
if ($_SESSION['category'] == "her")
{
	$menu = '<label onmousedown="chooseCategory(\'all\')">All</label> | 
      <label onmousedown="chooseCategory(\'tech\')">Tech</label> | 
      <label onmousedown="chooseCategory(\'funny\')">Funny</label> | 
      <label onmousedown="chooseCategory(\'useful\')">Useful</label> | 
      <label onmousedown="chooseCategory(\'fashion\')">Fashion</label> |      
      <label onmousedown="chooseCategory(\'him\')">Him</label> | 
      <label style="color:#CCC" onmousedown="chooseCategory(\'her\')">Her</label> |
      <label onmousedown="chooseCategory(\'toys\')">Toys/Kids</label>';
}
if ($_SESSION['category'] == "toys")
{
	$menu = '<label onmousedown="chooseCategory(\'all\')">All</label> | 
      <label onmousedown="chooseCategory(\'tech\')">Tech</label> | 
      <label onmousedown="chooseCategory(\'funny\')">Funny</label> | 
      <label onmousedown="chooseCategory(\'useful\')">Useful</label> | 
      <label onmousedown="chooseCategory(\'fashion\')">Fashion</label> |      
      <label onmousedown="chooseCategory(\'him\')">Him</label> | 
      <label onmousedown="chooseCategory(\'her\')">Her</label> |
      <label style="color:#CCC" onmousedown="chooseCategory(\'toys\')">Toys/Kids</label>';
}

?>
<?php 
include_once("phpIncludes/check_login_status.php");
if (isset($_POST['action']) && $_POST['action'] == "choose_category"){
	if(!isset($_POST['category']) || $_POST['category'] == ""){
		mysqli_close($dbConx);
		echo 1;
		exit();
	}
		$_SESSION['category'] = $_POST['category'];
		$_SESSION['lowlim'] = 0;
	
		mysqli_close($dbConx);
	    echo 2;
		exit();
}

?>
<script>
function searchStuff(){
	query = _("searchbar").value;
	if(!query == ""){
    var ajax = ajaxObj("POST", "search.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == 4){
				location.href = 'search.php?='+query;
			} else {
				alert("Error");
			}
		}
	}
	ajax.send("action=search_product&query="+query);
	}
}

function chooseCategory(category)
{
		var ajax = ajaxObj("POST", "pageTop.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == 2){
				location.href = 'index.php?='+category;
			} else {
				alert("There Was an Error");
			}
		}
	}
	ajax.send("action=choose_category&category="+category);
}
</script>
<div id="pageTop">
    <div id="pageTopWrap">
      <div id="pageTopLogo"><a onmousedown="chooseCategory('all')"><img src="images/logo.png" width="122" height="77" alt="SIWB" /></a></div>
      <div id="pageTopRest">
      <div id="links">
      <?php echo $loginLink; ?>
      <form  id="searchform" onsubmit="return false;">
    <input type="text" placeholder="Seach for stuff.." id="searchbar" maxlength="100">
    <button id="searchbtn" onclick="searchStuff()">Go</button> 
  </form>
      </div>
      <div id="menu"><b>
      <?php echo $menu; ?>
      </b></div>
      </div>
    </div>
  </div>
