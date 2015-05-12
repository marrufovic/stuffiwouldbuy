<?php 
include_once("phpIncludes/check_login_status.php");
if (isset($_POST['action']) && $_POST['action'] == "loader"){
	if(!isset($_POST['value']) || $_POST['value'] == ""){
		echo "error";
		exit();
	}

		if ($_POST['value'] == n){
		$_SESSION['lowlim'] = $_POST['low'] + 15;
		}
		
		else if ($_POST['value'] == p){
		$_SESSION['lowlim'] = $_POST['low'] - 15;
		}
		
		else if ($_POST['value'] == gf){
		$_SESSION['lowlim'] = 0;
		}
		
		else if ($_POST['value'] == gl){
		$_SESSION['lowlim'] = ($_SESSION['numberofpages'] * 15) - 15;
		}
		
		else{$_POST['value'] == "error";
		}
		
			    
		echo "good";
		exit();
	
}
?>
