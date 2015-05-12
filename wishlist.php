<?php 
include_once("phpIncludes/check_login_status.php");
$u = "";
$wishlist = "<tr>";
$rep=1;
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["u"])){
$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("location: index.php");
    exit();	
}
$sql = "SELECT productid FROM saves WHERE username='$u'";
$user_query = mysqli_query($dbConx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);

if($numrows >= 1){

// Check to see if the viewer is the account owner
$isOwner = "no";
if($u == $log_username && $user_ok == true){
$isOwner = "yes";
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
$productid = $row["productid"];

$sql1 = "SELECT * FROM products WHERE id='$productid'";
$query1 = mysqli_query($dbConx, $sql1);
while($row1 = mysqli_fetch_array($query1, MYSQLI_ASSOC)){
	$product = $row1["productname"];
	$image = $row1["image"];
	$link = $row1["link"];
	$description = $row1["description"];
	$saves = $row1["saves"];
	$price = number_format($row1["price"], 2);
	
	$deletebutton = '<div id="delete">X</div>';
	
	if($user_ok == true){
$deletebutton = '<a href="#"  onmousedown="deleteProduct('.$productid.',\''.$log_username.'\');" title="DELETE THIS PRODUCT"><div id="delete">X</div></a>';
}

$productlink =  '<label text-decoration:none;" onmousedown="productPage(\''.$productid.'\',\''.$product.'\');"  title="View This Product">'.$product.'</label>';
	
	$wishlist .= '<td><h3><div id="productName">'.$productlink.'</div>'.$deletebutton.'</h3><div id="productImage"><a href="http://www.amazon.com/gp/product/'.$link.'/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN='.$link.'&linkCode=as2&tag=stiwobu-20"><img src="products/'.$image.'" width="280" height="265" alt="'.$product.'"></a></div><div id="descriptionBox"><p>'.$description.'</p></div><div id="button"><a href="http://www.amazon.com/gp/product/'.$link.'/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN='.$link.'&linkCode=as2&tag=stiwobu-20"><img src="images/buybutton.png" width="118" height="41" alt="Buy It"></a></div><div id="price"><b>$'.$price.'</b></div><br/><div id="saves"><label><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label></div></td>';
	
	if ($rep % 3 == 0)
	{
		$wishlist.="</tr><tr>";
	}
	$rep++;

}
}
}

else{
$wishlist = "<p style='margin-left:50px;'>There is no \"stuff\" in your Wish List, press the <a href='index.php'><img src='images/save.png' width='22' height='22' alt='save'></a>  button to add an Item.</p>";	
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $u?>'s Wish List</title>
  <link rel="icon" href="images/favicon.png" type="imgage/png">
  <link rel="stylesheet" href="style/style.css" type="text/css">
  <script src="js/main.js"></script>
  <script src="js/ajax.js"></script>
  <script>
  function deleteProduct(productid,user){
	 var conf = confirm("Press OK to delete the product");
	if(conf != true){
		return false;
	}
	
	var ajax = ajaxObj("POST", "delete.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == user){
				window.location = "wishlist.php?u="+ajax.responseText;
			} else {
				alert("error: item not deleted");
			}
		}
	}
	ajax.send("action=delete&productid="+productid);
}

function productPage(productid,product){
	
	var ajax = ajaxObj("POST", "product.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == 4){
				location.href = 'product.php?='+product;
			} else {
				alert("Error");
			}
		}
	}
	ajax.send("action=display_product&productid="+productid);
}
  </script>
 
</head>
<body>
<?php include_once("pageTop.php") ?>
<div id="pageMiddle" style="background-color:#F2F2F2;">
  <div>
  <h2 style="color:#14ABCC; width:500px; line-height:1.5em; margin-left:50px; margin-top:50px; margin-bottom:0px;">
  <?php echo $u?>'s Wish List</h2>
  </div>
  <div id="mainContent">
  <table width="1000"  border="0">
  <tr><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td></tr>
   <?php echo $wishlist?>

</table>
  </div>
  </div>
<?php include_once("pageBottom.php") ?>
</body>
</html>
