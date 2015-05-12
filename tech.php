<?php include_once("phpIncludes/check_login_status.php");
$sql = "SELECT * FROM products WHERE category3 LIKE '%tech%'";
$query = mysqli_query($dbConx, $sql);
$productlist="<tr>";
$rep=1; 

while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
	$product = $row["productname"];
	$image = $row["image"];
	$link = $row["link"];
	$description = $row["description"];
	$saves = $row["saves"];
	$price = number_format($row["price"], 2);
	$productid = $row["id"];
	

$savebutton = '<label onmousedown="toLogin();" title="Save This Product"><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label>';
	
	if($user_ok == true){
$savebutton = '<label onmousedown="saveProduct('.$productid.');" title="Save This Product"><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label>';
}

$productlink =  '<div id="productName"><label text-decoration:none;" onmousedown="productPage(\''.$productid.'\',\''.$product.'\');"  title="View This Product">'.$product.'</label></div>';
	
	$productlist .= '<td><h3>'.$productlink.'</h3><div id="productImage"><img src="products/'.$product.'/'.$image.'" width="280" height="265" alt="'.$product.'"></div><div id="descriptionBox"><p>'.$description.'</p></div><div id="button"><a href="http://'.$link.'"><img src="images/buybutton.png" width="118" height="41" alt="Buy It"></a></div><div id="price"><b>$'.$price.'</b></div><br/><div id="saves">'.$savebutton.'</div></td>';
	
	if ($rep % 3 == 0)
	{
		$productlist.="</tr><tr>";
	}
	$rep++;

}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Tech Stuff</title>
  <link rel="icon" href="images/favicon.png" type="imgage/png">
  <link rel="stylesheet" href="style/style.css" type="text/css">
  <script src="js/main.js"></script>
  <script src="js/ajax.js"></script>
  <script>
  function saveProduct(productid){
	
	var ajax = ajaxObj("POST", "saveProduct.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == 2){
				alert("The Product Was Added To Your Wishlist");
			} else {
				alert("error: not added");
			}
		}
	}
	ajax.send("action=save_product&productid="+productid);
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

function sortBy(){
	var x = _("sortby").value;
	if (x == 1){
		location.href = 'index.php';
	}else if(x == 2){
		location.href = 'popular.php';
	}else if(x == 3){
		location.href = 'cheapest.php';
	}else if(x == 4){
		location.href = 'expensive.php';
	}else if(x == 5){
		location.href = 'random.php';
	}
}
</script>
</head>
<body>
<?php include_once("pageTop.php") ?>
<div id="wrapper">
 <div id="adTop">
  <h2>ADVERTISMENT</h2>
  </div>
  <div id="sort">
  <form name="sortform" id="sortform">
  Sort:
  <select id="sortby" onChange="sortBy()">
  <option value="1">Newest</option>
  <option value="2">Most Popular</option>
  <option value="3">Cheapest</option>
  <option value="4">Most Expensive</option>
  <option value="5">Surprise Me</option>
  </select>
  </form>  
  </div>
 <div id="shadow">
  <div id="pageMiddle">
  <div id="mainContent">
  <table width="1000"  border="0">
  <tr><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td></tr>
   <?php echo $productlist?>
</table>
  </div>
  </div>
</div>
<?php include_once("pageBottom.php") ?>
</div>
</body>
</html>
