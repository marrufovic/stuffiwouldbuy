  
  <?php include_once("phpIncludes/check_login_status.php");

$lowlim = 0;
if (isset($_SESSION['lowlim'])) {
$lowlim = $_SESSION['lowlim'];
}
$highlim = 15;

$sql = "SELECT * FROM products WHERE approved='1' ORDER BY id DESC LIMIT $lowlim, $highlim";
$sql2 = "SELECT * FROM products WHERE approved='1'";

$cat = $_SESSION['category'];

if (!($_SESSION['category'] == "all") && !($_SESSION['category'] == ""))
{
	$sql = "SELECT * FROM products WHERE approved='1' AND category LIKE '%$cat%' LIMIT $lowlim, $highlim";
	$sql2 = "SELECT * FROM products WHERE approved='1' LIKE '%$cat%' LIMIT $lowlim, $highlim";
}

$query2 = mysqli_query($dbConx, $sql2);
$all = mysqli_num_rows($query2);

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
	$urlname = $row["urlname"];
	

$savebutton = '<label onmousedown="toLogin();" title="Save This Product"><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label>';
	
	if($user_ok == true){
$savebutton = '<label onmousedown="saveProduct('.$productid.');" title="Save This Product"><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label>';
}

$productlink =  '<label text-decoration:none;" onmousedown="productPage(\''.$productid.'\',\''.$product.'\');"  title="View This Product">'.$product.'</label>';
	
	
$productlist .= '<td><h3><div id="productName">'.$productlink.'</div></h3><div id="productImage"><label text-decoration:none;" onmousedown="productPage(\''.$productid.'\',\''.$product.'\');"  title="View This Product"><img src="products/'.$image.'" width="280" height="265" alt="'.$product.'"></label></div><div id="descriptionBox"><p>'.$description.'</p></div><div id="button"><a href="http://www.amazon.com/gp/product/'.$link.'/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN='.$link.'&linkCode=as2&tag=stiwobu-20"><img src="images/buybutton.png" width="118" height="41" alt="Buy It"></a></div><div id="price"><b>$'.$price.'</b></div><br/><div id="saves">'.$savebutton.'</div></td>';
	
	if ($rep % 3 == 0)
	{
		$productlist.="</tr><tr>";
	}
	$rep++;

}


$_SESSION['numberofpages'] = ceil($all / 15);
$currentpage = ($lowlim / 15) + 1;

if ($lowlim > 0)
{
	$previous = '<label onmousedown="loader(\'p\','.$lowlim.');">Previous</label>';
} else 
{
	$previous = '<label onmousedown="loader(\'gl\','.$lowlim.');">Go to last page</label>';
}

if ($lowlim + 15 < $all)
{
	$next = '<label onmousedown="loader(\'n\','.$lowlim.');">Next</label>';
} else 
{
	$next = '<label onmousedown="loader(\'gf\','.$lowlim.');">Go to first page</label>';
}


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Stuff I Would Buy</title>
  <link rel="icon" href="images/favicon.png" type="imgage/png">
  <link rel="stylesheet" href="style/style.css" type="text/css">
  <script src="js/main.js"></script>
  <script src="js/ajax.js"></script>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44849287-1', 'stuffiwouldbuy.com');
  ga('send', 'pageview');

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

function toLogin(){	
location.href = 'login.php';
}

function loader(value,low){
	
	var ajax = ajaxObj("POST", "loader.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "good"){
				location.href = 'index.php?=<?php echo $_SESSION['category']?>';
			} else {
				alert(ajax.responseText);
			}
		}
	}
	ajax.send("action=loader&value="+value+"&low="+low);
}


</script>
</head>
<body>
<?php include_once("pageTop.php") ?>
<div id="wrapper">
 <div id="adTop">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Top index -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-3512811886582903"
     data-ad-slot="2828538871"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
  </div>
  <div id="adRight">
  <script type="text/javascript"><!--
google_ad_client = "ca-pub-3512811886582903";
/* Right index */
google_ad_slot = "2586363273";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
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
  <div id="adLeft">
  <script type="text/javascript"><!--
google_ad_client = "ca-pub-3512811886582903";
/* Left index */
google_ad_slot = "1109630076";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
  </div>
 <div id="shadow">
  <div id="pageMiddle" style="border-top:solid 1px #CCC;
	  border-bottom:solid 1px #CCC;">
  <div id="mainContent">
  <table width="1000"  border="0">
  <tr><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td></tr>
   <?php echo $productlist?>
</table>
<br>
<br>
<br>
<div id="adBottom">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Top index -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-3512811886582903"
     data-ad-slot="2828538871"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<br>
<br>
<br>
   <div id="productName" style="text-align: center;"><?php echo $previous?> - Page <?php echo $currentpage?> of <?php echo $_SESSION['numberofpages']?> - <?php echo $next?></div>
  </div>
  </div>
</div>
<?php include_once("pageBottom.php") ?>
</div>
</body>
</html>
