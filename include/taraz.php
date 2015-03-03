<?php if($taraz == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>

<?php
include('jdf.php');
error_reporting(E_ALL);
ini_set('display_errors','1');
date_default_timezone_set('Asia/Tehran');
?>

<?php
if(isset($_POST['submit'])){
	echo 'در دست طراحی!!!';
}else{
		echo "
		<h3 class='sub-header'>گزارش تراز ماهانه</h3>
		<div class='col-xs-6'>
		<h4 class='sub-header'>پذیرندگان</h4>	
	";
##### POR DARAMAD ###########
$porcountsum = 0 ;
$porcountsumconstant = 2500000 ;
##### KAM DARAMAD ###########
$kamcountsum = 0 ;
$kamcountsumconstant = 100000 ;
##### POR TARAKONESH ###########
$porcount = 0 ;
$porcountconstant = 100 ;
##### KAM TARAKONESH ###########
$kamcount = 0 ;
$kamcountconstant = 10 ;
##### pazirandegan faal ###########
$porcountusers = 0 ;
$porcountusersconstant = 50 ;
##### pazirandegan gheyre faal ###########
$kamcountusers = 0 ;
$kamcountusersconstant = 10 ;
##### kole sahamdarane moarefi shode #######
$total_users = 0;

	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");
	
	$every_receptor_query="SELECT * FROM receptors;";
	$every_receptor_result=$mysqli->query($every_receptor_query);
	
	while($every_receptor_row=$every_receptor_result->fetch_assoc()){
	### Gozaresh giri tarakonesh ha ###
	$terminalId = $every_receptor_row['terminal_id'];
	//$register_date = substr($every_body_row['register_date'],0,10);
	//$timestamp = strtotime($register_date);
	//$register_date = jdate("Y/m/d",$timestamp);
	
	$benefit_query="SELECT * FROM transaction WHERE terminalId='$terminalId';";
	$benefit_result=$mysqli->query($benefit_query);
	
	$count_query="SELECT COUNT(*) FROM transaction WHERE terminalId='$terminalId';";
	$count_result=$mysqli->query($count_query);
	$count_row=$count_result->fetch_assoc();
	$count = $count_row['COUNT(*)'];
	
	$sum = 0;
	while($benefit_row=$benefit_result->fetch_assoc()){
			$sum = $sum + $benefit_row['amount'];
	}

	####### daramad tarakonesh###########
	if($sum > $porcountsumconstant){
		$porcountsum++;
		}
	if($sum < $kamcountsumconstant){
		$kamcountsum++;
		}
	####### tedad tarakonesh###########
	if($count > $porcountconstant){
		$porcount++;
		}
	if($count < $kamcountconstant){
		$kamcount++;
		}
	### Gozaresh giri sahamdaran ###
	$mobile = $every_receptor_row['receptor_mobile'];
		if($mobile!=NULL){
			$marketers_query = "SELECT * FROM marketers WHERE mobile='$mobile' ; ";
			$marketers_result = $mysqli->query($marketers_query);
			
			$marketers_row = $marketers_result->fetch_assoc();
													
									$marketers_id = $marketers_row['id'];

									if($marketers_id){
									$marketers_count_query="SELECT * FROM users WHERE marketers_id='$marketers_id'; ";
									$marketers_count_result=$mysqli->query($marketers_count_query);
									$marketers_count_row=$marketers_count_result->fetch_assoc();
									$count_users = $marketers_count_result->num_rows;
									$total_users = $count_users + $total_users;
									}
		}
	#######tedad sahamdar ###########
	if($count_users > $porcountusersconstant){
		$porcountusers++;
		}
	if($count_users < $kamcountusersconstant){
		$kamcountusers++;
		}
	
	
}
$porcountsumconstant = number_format($porcountsumconstant,0,'.',',');
$kamcountsumconstant = number_format($kamcountsumconstant,0,'.',',');

echo "<ul>
		<li><label>تعداد پذیرندگان فعال (حداقل هر ماه $porcountusersconstant نفر معرفی کرده اند )</label> : <span class='tarazvalue'>$porcountusers</span></li>
		<li><label>تعداد پذیرندگان غیر فعال (پایین تر از $kamcountusersconstant نفر در ماه معرفی کرده اند)</label> : <span class='tarazvalue'>$kamcountusers</span></li><hr>
		<li><label>تعداد سهامدار معرفی شده توسط پذیرندگان</label> : <span class='tarazvalue'>$total_users</span></li><hr>
		<li><label>تعداد پذیرندگان پرتراکنش (بالای $porcountconstant تراکنش در ماه) </label> : <span class='tarazvalue'>$porcount</span></li>
		<li><label>تعداد پذیرندگان کم تراکنش (زیر $kamcountconstant تراکنش در ماه) </label> : <span class='tarazvalue'>$kamcount</span></li><hr>
		<li><label>تعداد پذیرندگان پر درآمد (بیش از $porcountsumconstant ریال در ماه)</label> : <span class='tarazvalue'>$porcountsum</span></li>
		<li><label>تعداد پذیرندگان کم درآمد (زیر $kamcountsumconstant ریال در ماه)</label> : <span class='tarazvalue'>$kamcountsum</span></li>
	  </ul>";
echo "
</div>
<div class='col-xs-6'>
<h4 class='sub-header'>سهامداران</h4>
";
##### faal users ###########
$faaluserscount = 0 ;
$faal_users = 1 ;
##### tak kharid ###########
$takkharidcount = 0 ;
$takkharid_users = 1 ;
##### sahamdarane dar hale estefade ba 2 tarakonesh dar mah ###########
$faaluserscountportarakonesh = 0 ;
$faal_users_por_tarakonesh = 2 ;
##### sahamdarane dar hale estefade ba 25000 rial dar mah ###########
$countuserssum = 0 ;
$countuserssumconstant = 25000 ;
##### sahamdarane ba sarmaye gozarie bish az 10000 toman ###########
$porcountuserssum = 0 ;
$porcountuserssumconstant = 100000 ;
##### total_money ###########
$total_money = 0 ;
##### total poole salem ###########
$poolesalem = 0 ;
$poolesalemconstant = 200;
##### tedade vojoohe salem ###########
$countsalem = 0 ;
##### tedade vojoohe na salem ###########
$countnasalem = 0 ;


$count_users_query="SELECT COUNT(*) FROM users;";
	$count_users_result=$mysqli->query($count_users_query);
	$count_users_row=$count_users_result->fetch_assoc();
	$count_users = $count_users_row['COUNT(*)'];
	
	$every_body_query="SELECT * FROM users;";
	$every_body_result=$mysqli->query($every_body_query);
	
	while($every_body_row=$every_body_result->fetch_assoc()){
	### Gozaresh giri ###
	$id=$every_body_row['id'];
	$register_date = substr($every_body_row['register_date'],0,10);
	$timestamp = strtotime($register_date);
	$register_date = jdate("Y/m/d",$timestamp);
	
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
			$sum = $sum + $amount;
		if($sum != 0){
			$count_users_tarakonesh++;
			}
			//sahm 80 darsad
			//$amountsum = (($transaction_row['amount']*80)/100)+$amountsum;
			//sahm 100 darsad
				$amountsum = $transaction_row['amount']+$amountsum;
			
		}
		if($amountsum > $poolesalemconstant){
			$countsalem++;
			}
			$countnasalem++;
		
	}
	$sum2 = number_format($sum,0,'.',',');
	$amountsum2 = number_format($amountsum,0,'.',',');

		  ####### sahamdarane faal ###########
		if($count_users_tarakonesh >= $faal_users){
			$faaluserscount++;
			}
			####### sahamdarane faal  tak kharid ###########
		if($count_users_tarakonesh == $takkharid_users){
			$takkharidcount++;
			}
		####### sahamdarane balaye 2 tarakonesh ###########
		if($count_users_tarakonesh > $faal_users_por_tarakonesh){
			$faaluserscountportarakonesh++;
			}
		####### sahamdarane balaye 25000 rial dar mah ###########
		if($amountsum > $countuserssumconstant){
			$countuserssum++;
			}
		####### sahamdarane ba sarmaye gozarie bish az 10000 toman ###########
		if($amountsum > $porcountuserssumconstant){
			$porcountuserssum++;
			}
		####### total money ###########
		$total_money = $amountsum + $total_money;
		
		####### total poole salem ###########
		if($amountsum > $poolesalemconstant){
			//$countsalem++;
		$poolesalem = $amountsum + $poolesalem;
		}
		
}
$total_money = number_format($total_money,0,'.',',');
$poolesalem = number_format($poolesalem,0,'.',',');

$countuserssumconstant = number_format($countuserssumconstant,0,'.',',');
$porcountuserssumconstant = number_format($porcountuserssumconstant,0,'.',',');
$poolesalemconstant = number_format($poolesalemconstant,0,'.',',');


echo "<ul>
		<li><label>تعداد کل ثبت نامی ها</label> : <span class='tarazvalue'>$count_users</span></li>
		<li><label>تعداد کل سهامداران</label> : <span class='tarazvalue'>$faaluserscount</span></li>
		<li><label>تعداد سهامداران با یک خرید</label> : <span class='tarazvalue'>$takkharidcount</span></li><hr>
		<li><label>سهامداران در حال استفاده ($countuserssumconstant ریال در ماه)</label> : <span class='tarazvalue'>$countuserssum</span></li>
		<li><label>سهامداران در حال استفاده (بالای $faal_users_por_tarakonesh تراکنش در ماه)</label> : <span class='tarazvalue'>$faaluserscountportarakonesh</span></li>
		<li><label>سهامداران با سرمایه گذاری بیش از $porcountuserssumconstant ریال</label> : <span class='tarazvalue'>$porcountuserssum</span></li><hr>
		<li><label>مجموع مبالغ جمع آوری شده</label> : <span class='tarazvalue'>$total_money ریال</span></li>
		<li><label>وجوه جمع آوری شده سالم (تراکنش با ارزش بالای $poolesalemconstant ریال)</label> : <span class='tarazvalue'>$poolesalem</span></li><hr>
		<li><label>تعداد کل تراکنش های سالم</label> : <span class='tarazvalue'>$countsalem</span></li>
		<li><label>تعداد کل تراکنش ها</label> : <span class='tarazvalue'>$countnasalem</span></li>
	  </ul>";
}
?>
</div>
<hr>
<form role="form" method="post">
<input type="submit" name="submit" class="btn btn-primary form-group" value="گزارش کلی"> 
</form>
</div>