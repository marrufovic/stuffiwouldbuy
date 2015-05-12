<?php 
include_once("phpIncludes/check_login_status.php");
if (isset($_POST['action']) && $_POST['action'] == "display_product"){
	if(!isset($_POST['productid']) || $_POST['productid'] == ""){
		mysqli_close($dbConx);
		echo 3;
		exit();
	}

        $_SESSION['productid'] = $_POST['productid'];
		mysqli_close($dbConx);
	    echo 4;
		exit();
	
}
?>
<?php
$productid = $_SESSION['productid'];
$sql = "SELECT * FROM products WHERE id='$productid'";
$query = mysqli_query($dbConx, $sql);

$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
$product = $row["productname"];
$image = $row["image"];
$link = $row["link"];
$description = $row["description"];
$saves = $row["saves"];
$price = number_format($row["price"], 2);

$savebutton = '<label onmousedown="toLogin();" title="Save This Product"><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label>';
	
	if($user_ok == true){
$savebutton = '<label onmousedown="saveProduct('.$productid.');" title="Save This Product"><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label>';
}

$productdisplay ='
<div id="productWrapper">

<div id="indProduct">
  <div id="indImage"><a href="http://www.amazon.com/gp/product/'.$link.'/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN='.$link.'&linkCode=as2&tag=stiwobu-20">
  <img src="products/'.$image.'" width="265" height="265"  alt="'.$product.'"><a>
  </div>
  <div id="descriptionTitleBox"><div id="indDescription">'.$description.'</div>
  <div id="priceSaveBox"><div id="indPrice"><b>$'.$price.'</b></div>
  
<div id="indButton"><a href="http://www.amazon.com/gp/product/'.$link.'/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN='.$link.'&linkCode=as2&tag=stiwobu-20"><img src="images/buybutton.png" width="118" height="41" alt="Take A Look"></a></div>
  
  <div id="indSaves"><b> '.$savebutton.' </b></div>
  
  <div id="socialNetworks">
  
  <div class="fb-like" data-href="http://www.stuffiwouldbuy.com/product.php?='.$product.'" data-width="450" data-layout="button_count" data-show-faces="true" data-send="false"></div>
  
  
  <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
  
  </div>
  
  </div>
  </div>
  </div>
  </div>';


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta property="fb:admins" content="{535160666}"/>
  <title><?php echo $product ?></title>
  <link rel="icon" href="images/favicon.png" type="imgage/png">
  <link rel="stylesheet" href="style/style.css" type="text/css">
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=185752161568642";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

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

function toLogin(){
location.href = 'login.php';
}


!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

</script>

  </head>
<body>
<?php include_once("pageTop.php") ?>
<div id="pageMiddle" style="background-color:#F2F2F2;">
  <div>
  <h2 style="color:#14ABCC; width:500px; line-height:1.5em; margin-left:50px; margin-top:50px; margin-bottom:0px;"><?php echo $product ?></h2>
  </div>
  <div id="mainContent">
  <div id="adIndividual">
  <div id="adIndividual1">
  <script type="text/javascript"><!--
google_ad_client = "ca-pub-3512811886582903";
/* Main individual */
google_ad_slot = "4063096474";
google_ad_width = 250;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
  </div>
  <div id="adIndividual2">
  <script type="text/javascript"><!--
google_ad_client = "ca-pub-3512811886582903";
/* Main Individual 2 */
google_ad_slot = "2446762475";
google_ad_width = 250;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
  </div>
  </div>
  <?php echo $productdisplay ?>
    <div id="fb-root"></div>
<div  style="margin-left:50px; margin-top:0px; "class="fb-comments" data-href="http://www.stuffiwouldbuy.com/product.php?=<?php echo $product ?>" data-width="650"></div>
  </div>
  </div>
<?php include_once("pageBottom.php") ?>
</body>
</html>
