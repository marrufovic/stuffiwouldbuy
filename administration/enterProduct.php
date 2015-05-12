<?php 
include_once("../phpIncludes/check_login_status.php");

if($_POST[upload] == "1")
	{
		$picurl = "..products/".$_FILES['file']['name'];
   	if (file_exists($picurl)) {
	unlink($picurl);
   }
		$to = "../products/".$_FILES['file']['name'];
		if (move_uploaded_file($_FILES['file']['tmp_name'], $to)){
		print "uploaded";
		}
	}

if (isset($_POST['action']) && $_POST['action'] == "add_product"){
	
	$pn = mysqli_real_escape_string($dbConx, $_POST['pn']);
	$u = mysqli_real_escape_string($dbConx, $_POST['u']);
	$i = mysqli_real_escape_string($dbConx, $_POST['i']);
	$l = mysqli_real_escape_string($dbConx, $_POST['l']);
	$d = mysqli_real_escape_string($dbConx, $_POST['d']);
	$pr = mysqli_real_escape_string($dbConx, $_POST['pr']);
	$c = mysqli_real_escape_string($dbConx, $_POST['c']);
	
	
	mysqli_query($dbConx, "INSERT INTO products (productname, image, link, description, price, category, urlname) 
	VALUES ('$pn', '$i', '$l', '$d', '$pr', '$c', '$u')");
	
	
		mysqli_close($dbConx);
	    echo "added";
		exit();

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../js/main.js"></script>
<script src="../js/ajax.js"></script>
<script>
function addProduct(){
var pn = _("productname").value;
var u = _("url").value;
var l = _("link").value;
var i = _("image").value;
var d = _("description").value;
var pr = _("price").value;
var c = _("category").value;

if(pn == "" || u == "" || i == "" || l == "" || d == ""|| pr == "" || c == ""){
alert("Fill out all of the form data");
} else {
_("addproduct").style.display = "none";
status.innerHTML = 'please wait ...';
var ajax = ajaxObj("POST", "enterProduct.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           if(ajax.responseText != "added"){
status.innerHTML = ajax.responseText;
_("addproduct").style.display = "block";
alert(ajax.responseText);
} else {
//window.location = "index.php?u="+u;
alert("product added!");
}
       }
        }
        ajax.send("action=add_product&pn="+pn+"&u="+u+"&i="+i+"&l="+l+"&d="+d+"&pr="+pr+"&c="+c);
}
}

</script>
</head>

<body>

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="upload" value="1">
<input id="file" type="file" name="file">
<input type="submit" value="upload">
</form>

<form name="Productform" id="Productform" onSubmit="return false;">
  <div>Product Name: </div>
  <input id="productname" type="text" maxlength="25">ex: Foosball Coffee Table
  <div>URL Name: </div>
  <input id="url" type="text" maxlength="25">ex: Foosball_Coffee_Table   
  <div>Link: </div>
  <input id="link" type="text">ex: B00.....
  <div>Image: </div>
  <input id="image" type="text">Foosball_Coffee_Table.jpg
  <div>Description: </div>
  <input id="description" type="text">
  <div>Price: </div>
  <input id="price" type="number" step="any" min="0">
  ex: 45500.95
  <div>Category: </div>
  <input id="category" type="text">options: tech funny useful fashion him her toys (when multiple separate with a space)
  <br /><br />
  <button id="addproduct" onClick="addProduct()">Add Product</button>
  </form>

</body>
</html>
