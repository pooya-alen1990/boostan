<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
ob_start();
date_default_timezone_set('Asia/Tehran');
$i = 1 ;
$sum = 0;
	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");
	
	if(isset($_POST['keyword'])){
		$keyword = $_POST['keyword'];
		$search_query = "SELECT * FROM receptors WHERE receptor_name LIKE '%$keyword%' AND city='تبریز' ";
		$search_result = $mysqli->query($search_query);
		
		while($search_row = $search_result->fetch_assoc()){
				if($search_row['city']=='تهران'){
					$change_color = 'green';
					}else{
					$change_color = 'purple';	
						}
				echo "<span class='btn-link test' style='color:$change_color' value='$search_row[receptor_name]'>$search_row[receptor_name]</span> - ";
			}
	}
?>