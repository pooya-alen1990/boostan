<?php if($advance_search == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class='sub-header'>جستجوی پیشرفته</h3>
<h4 class='sub-header'>پذیرنده</h4>
<?php
include('jdf.php');
error_reporting(E_ALL);
ini_set('display_errors','1');
date_default_timezone_set('Asia/Tehran');

	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");
	
?>
<form method="post" role="form" class="form-inline">
            <select name="city" class="form-control" style='min-width:200px'>
<?php 
				$test = array();
				
				$sql = "SELECT * FROM receptors";
					$res = $mysqli->query($sql);
					$category = '<option value="total">همه</option>';
					while($row=$res->fetch_assoc())
					{
						if(!in_array($row['city'],$test)){
							$active='';
							if($_POST['city'] == $row['city']){
								$active = 'selected';
								}
						$category .= '<option value="'.$row['city'].'" '.$active.'>'.$row['city'].'</option>';
							array_push($test,$row['city']);
							}
						
					}
				echo $category;
				 ?>
            </select>
        <input type="submit" name="step1" value="تغییر شهر" class="form-control btn btn-primary">
        </form><br>
<?php
    
			echo "<form method='post' role='form' class='form-inline'>	
			<select name='zone' class='form-control' style='min-width:200px'>";
			if(isset($_POST['step1'])){
				$city = $_POST['city'];
				$test2 = array();
		
				$sql2 = "SELECT * FROM receptors WHERE 1=1 ";
				if($city!='total'){
				$sql2 .= " AND city='$city' ";
				}
					$res2 = $mysqli->query($sql2);
					
					$category2 = '<option value="total">همه</option>';
					while($row2=$res2->fetch_assoc())
					{
						if(!in_array($row2['receptor_zone'],$test2)){
							$active2='';
							if($_POST['zone'] == $row2['receptor_zone'] and $_POST['zone'] != NULL){
								$active2 = 'selected';
								}
						$category2 .= '<option value="'.$row2['receptor_zone'].'" '.$active2.'>'.$row2['receptor_zone'].'</option>';
							array_push($test2,$row2['receptor_zone']);
							}
						
					}
				echo $category2;}
			echo "</select>
			<input type='hidden' name='city' value='$city'>
			<input type='hidden' name='step1' value='step1'>
					<input type='submit' name='step2' value='تغییر محله' class='form-control btn btn-primary'>
				</form>
			";
		
	
?>
<?php
    if(isset($_POST['step2'])){
		$city = $_POST['city'];
		$receptor_zone = $_POST['zone'];

				$sql3 = "SELECT * FROM receptors WHERE 1=1 ";
				if($city!='total'){
				$sql3 .= " AND city='$city' ";
				}
				if($receptor_zone!='total'){
				$sql3 .= " AND receptor_zone='$receptor_zone' ";
				}
				
				
				#############################################################################################
												echo "
								<div class='col-xs-12'><br>
								<h4 class='sub-header'>لیست پذیرندگان جستجو شده</h4>	
								<table class='table table-striped table-hover table-bordered'>
										<tr>
											<th>ردیف</th>
											<th>نام و نام خانوادگی</th>
											<th>نام فروشگاه</th>
											<th>شماره پایانه</th>
											<th>درصد تخفیف</th>
											<th>شماره موبایل</th>
											<th>شماره تلفن</th>
											<th>آدرس</th>
											<th>مبلغ سود</th>
											<th>تعداد خرید</th>               
										</tr>
							";
						$i2 = 1 ;
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
						$count_users = 0;

							
							//$every_receptor_query="SELECT * FROM receptors;";
							//$every_receptor_result=$mysqli->query($every_receptor_query);
							$every_receptor_result = $mysqli->query($sql3);
							
							while($every_receptor_row=$every_receptor_result->fetch_assoc()){
								//////////////////////////////////////LIST///////////////////////////////////////////
								$terminalId=$every_receptor_row['terminal_id'];
								//$register_date = substr($find_row['register_date'],0,10);
								//$timestamp = strtotime($register_date);
								//$register_date = jdate("Y/m/d",$timestamp);
								
								$benefit_query="SELECT * FROM transaction WHERE terminalId='$terminalId';";
								$benefit_result=$mysqli->query($benefit_query);
								
								$count_query="SELECT COUNT(*) FROM transaction WHERE terminalId='$terminalId';";
								$count_result=$mysqli->query($count_query);
								$count_row2=$count_result->fetch_assoc();
								$count2 = $count_row2['COUNT(*)'];
								
								$sum2 = 0;
								while($benefit_row=$benefit_result->fetch_assoc()){
										$sum2 = $sum2 + $benefit_row['amount'];
								}
								$sum=number_format($sum2,0,'.',',');
								echo "
									  <tr>
												<td>$i2</td>
												<td>$every_receptor_row[first_name] $every_receptor_row[last_name]</td>
												<td>$every_receptor_row[receptor_name]</td>
												<td>$every_receptor_row[terminal_id]</td>
												<td>$every_receptor_row[discount]</td>
												<td>$every_receptor_row[receptor_mobile]</td>
												<td>$every_receptor_row[receptor_tel]</td>
												<td>منطقه : $every_receptor_row[receptor_zone_code] -  
													محله : $every_receptor_row[receptor_zone] - 
													$every_receptor_row[receptor_address]
													</td>
												<td>$sum2</td>
												<td>$count2</td>	
									  </tr>";
								$i2++;
							////////////////////////////////////////////////////////////END LIST////////////////////////	
							//while($row3=$res3->fetch_assoc()){
							### Gozaresh giri tarakonesh ha ###
							$terminalId = $every_receptor_row['terminal_id'];
							//$register_date = substr($find_row['register_date'],0,10);
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
						echo "</table>";
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

				
				#############################################################################################
					

		}
	
?>
<hr style="border-color:red !important">
<h4 class='sub-header'>سهامدار</h4>
<?php
##### faal users ###########
$faaluserscount = 0 ;
$faal_users = 1 ;
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
$poolesalemconstant = 2000;
##### tedade vojoohe salem ###########
$countsalem = 0 ;
##### tedade vojoohe na salem ###########
$countnasalem = 0 ;

$i3 = 1;
$bishaz = 10000 ;
if(isset($_POST['users_find'])){
	$keyword = $_POST['keyword'];
	$bishaz = $_POST['bishaz'];
				$find_query="SELECT * FROM users
					WHERE first_name LIKE '%$keyword%'
					OR last_name LIKE '%$keyword%'
					OR mobile LIKE '%$keyword%'
					OR melli_code LIKE '%$keyword%'
					OR cart_pri LIKE '%$keyword%'
					OR cart_sec LIKE '%$keyword%'
					OR cart_ter LIKE '%$keyword%'
					;";
				$find_result=$mysqli->query($find_query);
				echo "
					<div class='table-responsive'>
						<table class='table table-striped table-hover table-bordered'>
							<tr>
								<th>ردیف</th>
								<th>نام</th>
								<th>نام خانوادگی</th>
								<th>کد ملی</th>
								<th>جنسیت</th>
								<th>شماره موبایل</th>
								<th dir='ltr'>کارت اول</th>
								<th dir='ltr'>کارت دوم</th>
								<th dir='ltr'>کارت سوم</th>
								<th>تاریخ ثبت نام</th>
								<th>وضعیت</th>
								<th>سرمایه گذاری بیش از $bishaz ریال</th>
							</tr>
				";
				while($find_row=$find_result->fetch_assoc()){
					$darhaleestefade = false;
					$bishaz_flag = false;
				//inja//
				### Gozaresh giri ###
	$id=$find_row['id'];
	$register_date = substr($find_row['register_date'],0,10);
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
			if(isset($amount)){$sum = $sum + $amount;}
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
		if($count_users_tarakonesh > $faal_users){
			$faaluserscount++;
			}
		####### sahamdarane balaye 2 tarakonesh ###########
		if($count_users_tarakonesh > $faal_users_por_tarakonesh){
			$faaluserscountportarakonesh++;
			}
		####### sahamdarane balaye 25000 rial dar mah ###########
		if($amountsum > $countuserssumconstant){
			$countuserssum++;
			$darhaleestefade = true;
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
		################
		if($darhaleestefade==true){
			$darhaleestefade = '<span style="color:green;">در حال استفاده</span>';
			}else{
				$darhaleestefade = '<span style="color:red;">عدم استفاده</span>';
				}
		############################
		if($amountsum > $bishaz){
			//$porcountuserssum++;
			$bishaz_flag = true;
			}
		#############################
		if($bishaz_flag==true){
			$bishaz_flag = '<span style="color:green;">دارد</span>';
			}else{
				$bishaz_flag = '<span style="color:red;">ندارد</span>';
				}
				
				echo "
					  <tr >		
								<td>$i3</td>
								<td width='100'>
								<a target='_blank' title='ویرایش اطلاعات' href='index.php?page=users_edit&user_mobile=$find_row[mobile]'><span class='glyphicon glyphicon-pencil' style='color:blue;'></span></a>
								<a target='_blank' title='نمایش پیگیری' href='index.php?page=follow_list&user_id=$find_row[id]'><span class='glyphicon glyphicon-phone-alt' style='color:green;'></span></a>
								<a target='_blank' title='نمایش سهام' href='index.php?page=stock_list&id=$find_row[id]'><span class='glyphicon glyphicon-paperclip' style='color:red;'></span></a>
								<a href='index.php?page=transactions_list&id=$find_row[id]' target='_blank'>$find_row[first_name]</a></td>
								<td width='100'><a href='index.php?page=transactions_list&id=$find_row[id]' target='_blank'>$find_row[last_name]</a></td>
								<td width='110'>$find_row[melli_code]</td>
								<td width='20'>$find_row[gender]</td>
								<td width='115'>$find_row[mobile]</td>
								<td dir='ltr'>$find_row[cart_pri]:$find_row[payerId]</td>
								<td dir='ltr'>$find_row[cart_sec]:$find_row[payerId2]</td>
								<td dir='ltr'>$find_row[cart_ter]:$find_row[payerId3]</td>
								<td>$register_date</td>
								<td width='105'>$darhaleestefade</td>
								<td width='105'>$bishaz_flag</td>	
					  </tr>";
				$i3++;
			}
			echo "
				</table>
				</div><hr>";
			$total_money = number_format($total_money,0,'.',',');
			$poolesalem = number_format($poolesalem,0,'.',',');
			
			$countuserssumconstant = number_format($countuserssumconstant,0,'.',',');
			$porcountuserssumconstant = number_format($porcountuserssumconstant,0,'.',',');
			$poolesalemconstant = number_format($poolesalemconstant,0,'.',',');
			
			
			echo "<ul>
					<li><label>تعداد سهامداران فعال</label> : <span class='tarazvalue'>$faaluserscount</span></li><hr>
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
<form method="post" role="form" class="form-inline">
	جستجو بر اساس نام / نام خانوادگی / شماره موبایل / کد ملی / شماره کارت: <input type="text" name="keyword" class="form-control">
   در صورت خالی گذاشتن این فیلد جستجو روی همه سهامداران انجام می شود.
   <br><br>
   	سهامداران با سرمایه گذاری بیش از <input type="text" name="bishaz" value="<?php echo $bishaz; ?>" class="form-control"> ریال علامت گذاری شوند.
    <br><br>
	<input type="submit" name="users_find" value="جستجو" class="form-control btn btn-primary">
</form><br>