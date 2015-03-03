<?php if($stock_management == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">مدیریت سهام</h3>
<?php
include('jdf.php');
error_reporting(E_ALL);
ini_set('display_errors','1');
ob_start();
date_default_timezone_set('Asia/Tehran');
include('include/stock_functions.php');


	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");
	
################################# Updating users to stocks ##########

##### havaset bashe hatman fielde user_id unique bashe too database vagarna hame chi kharab mishe  #####
if(isset($_POST['update_users'])){
	$fetch_query = "SELECT * FROM users ; ";
	$fetch_result = $mysqli->query($fetch_query);

	while($fetch_row = $fetch_result->fetch_assoc()){
		$insert_query = "INSERT INTO `stock`(`id`, `users_id`) VALUES ('','$fetch_row[id]') ; ";
		$insert_result = $mysqli->query($insert_query);
		}
		
	}
echo '
	<form role="form" method="post" class="form-inline">
	<input type="submit" class="form-control btn btn-success" value="به روز رسانی کاربران" name="update_users">
	</form>
';
#####################################################################

################################# etaye saham be 3 mahe sevom sale 93 ############################################
if(isset($_POST['execute'])){
	
	$all_query = "SELECT * FROM stock WHERE id>5626 ; ";
	$all_result = $mysqli->query($all_query);
	
	while($all_row = $all_result->fetch_assoc()){
			$users_id = $all_row['users_id'];					
				
			$mobile_query = "SELECT id,mobile FROM users WHERE id='$users_id' ; ";
			$mobile_result = $mysqli->query($mobile_query);
			$mobile_row = $mobile_result->fetch_assoc();
			
			$mobile = $mobile_row['mobile'];
			$from = '2014/09/23';
			$to = '2014/12/22';
			$price_per_share = 8000;
			
			$stock_amount = stock_amount($from,$to,$mobile,$mysqli);
			$stock_count = stock_count($stock_amount,$price_per_share);
			$stock_remain = stock_remain($stock_amount,$price_per_share);		

			$update_query = "UPDATE `stock` SET `933_amount`='$stock_amount',`933_count`='$stock_count',`933_remain`='$stock_remain'
									 WHERE users_id='$users_id' ; ";
			$update_result = $mysqli->query($update_query);

	}
}
echo '<hr>
	<form role="form" method="post" class="form-inline">
	<input type="submit" class="form-control btn btn-primary" value="اعطای سهام" name="execute">
	</form>
<hr>پاییز 93';
####################################################################################################################	
?>