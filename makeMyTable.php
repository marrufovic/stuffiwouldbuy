<?php
include_once("phpIncludes/dbConx.php");

$tbl_users = "CREATE TABLE IF NOT EXISTS users(
			 id INT(11) NOT NULL AUTO_INCREMENT,
			 username VARCHAR(16) NOT NULL,
			 email VARCHAR(255) NOT NULL,
			 password VARCHAR(255) NOT NULL,
			 website VARCHAR(255) NULL,
			 ip VARCHAR(255) NOT NULL,
			 country VARCHAR(255) NULL,
			 PRIMARY KEY(id),
			 UNIQUE KEY username (username, email)
			 )";
			 
$query = mysqli_query($dbConx, $tbl_users);
if ($query === TRUE){
	print ("<h1>Table Users Was Created!</h1>");}
	else{
	print ("<h1>Table Was NOT Created...</h1>");}
	
/////////////////////////////////////////////////////////////////////////

$tbl_saves = "CREATE TABLE IF NOT EXISTS saves(
				   id INT(11) NOT NULL AUTO_INCREMENT,
				   username VARCHAR(16) NOT NULL,
				   productid INT(11) NOT NULL,
				   PRIMARY KEY(id),
				   UNIQUE KEY username (username, productid)
				   )";
				   
$query = mysqli_query($dbConx, $tbl_saves);
if ($query === TRUE)
	print ("<h1>Table Saves Was Created!</h1>");
	else 
	print ("<h1>Table Was NOT Created</h1>");
	
//////////////////////////////////////////////////////////////////

$tbl_products = "CREATE TABLE IF NOT EXISTS products(
				id INT(11) NOT NULL AUTO_INCREMENT,
				productname VARCHAR(16) NOT NULL,
				image VARCHAR(255) NOT NULL,
				link VARCHAR(255) NOT NULL,
				description VARCHAR(255) NOT NULL,
				saves INT(11) NOT NULL DEFAULT '0',
				price DECIMAL(10,2) NOT NULL,
				category ENUM('a','b','c','d','e','f','g') NOT NULL DEFAULT 'a',
				PRIMARY KEY(id),
				UNIQUE KEY username (productname)
				)";	
	
$query = mysqli_query($dbConx, $tbl_products);
if ($query === TRUE)
	print ("<h1>Table Products Was Created!</h1>");
	else 
	print ("<h1>Table Was NOT Created</h1>");	
	
?>
