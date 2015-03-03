<?php if($users_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست سهامداران</h3>
<div class="table-responsive text-center">
            <table class="table table-striped table-hover table-bordered tablesorter">
               <thead>
                <tr>
					<th>ردیف</th>
					<th>نام و نام خانوادگی</th>
                    <th>جنسیت</th>
                    <th>شماره موبایل</th>
					<th>مجموع سود</th>
				</tr>
                </thead>
                <tbody>
<?php

error_reporting(E_ALL);
ini_set('display_errors','1');

	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");		
	
	$every_body_query="SELECT * FROM users ;";	
	
	$every_body_result=$mysqli->query($every_body_query);
	
	while($every_body_row=$every_body_result->fetch_assoc()){
	### Gozaresh giri ###
	$id=$every_body_row['id'];	
	
	$cart_query="SELECT * FROM users WHERE id='$id';";
	$cart_result=$mysqli->query($cart_query);
	$cart_row=$cart_result->fetch_assoc();
	$cart_pri= $cart_row['cart_pri'];
	$cart_sec= $cart_row['cart_sec'];
	$cart_ter= $cart_row['cart_ter'];
	$payerId= $cart_row['payerId'];
	$payerId2= $cart_row['payerId2'];
	$payerId3= $cart_row['payerId3'];
	
	$transaction_query = "SELECT * FROM transaction WHERE (pan='$cart_pri' AND payerId='$payerId') 
																	OR (pan='$cart_sec' AND payerId='$payerId2') 
																			OR (pan='$cart_ter' AND payerId='$payerId3') ; ";
	$transaction_result = $mysqli->query($transaction_query);
	$sum = 0;
	$amountsum = 0;
	$count_users_tarakonesh = 0;
	while($transaction_row=$transaction_result->fetch_assoc()){
		if($transaction_row['accountNumber']=='4975553214'){
			
			$terminalid = $transaction_row['terminalId'];
			$terminalid_query="SELECT * FROM receptors WHERE terminal_id='$terminalid'; ";
			$terminalid_result=$mysqli->query($terminalid_query);
			$terminalid_row=$terminalid_result->fetch_assoc();
			
			if($terminalid_row['discount'] != 0){
			$amount = ($transaction_row['amount']*100)/$terminalid_row['discount'];
			}
			//echo '<pre>';
			//print_r($transaction_row);
			//echo '</pre>';
			$sum = $sum+$amount;
			if($sum != 0){
			$count_users_tarakonesh++;
			}
			//sahm 80 darsad
			//$amountsum = (($transaction_row['amount']*80)/100)+$amountsum;
			//sahm 100 darsad
				$amountsum = $transaction_row['amount']+$amountsum;		
		}	
	}
	
	$amountsum=number_format($amountsum,0,'.',',');
	if($every_body_row['gender'] == 'مرد'){
		$gender = 'آقای';
		}else if($every_body_row['gender'] == 'زن'){
			$gender = 'خانم';
			}
					
	echo "<tr>
			  <td>$every_body_row[id]</td>
			  <td>$every_body_row[last_name]</td>
			  <td>$gender</td>
			  <td>$every_body_row[mobile]</td>
			  <td>$amountsum</td>		
		  </tr>";
		  
	$baraye_sms_query="INSERT INTO users_baraye_sms (id,last_name,gender,mobile,amountsum,settings_flag) VALUES 	('$every_body_row[id]','$every_body_row[last_name]','$gender','$every_body_row[mobile]','$amountsum' , '$every_body_row[settings_flag]');";
	$mysqli->query($baraye_sms_query);
}
?>
</tbody>
</table>
</div>