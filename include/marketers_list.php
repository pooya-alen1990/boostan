<?php if($marketers_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست بازاریابان</h3>
فعالیت دیروز بازاریابان
    <table class="table table-striped table-hover table-bordered tablesorter">
    		<thead>
				<tr>
					<th>کد مدیر فروش</th>
					<th>نام و نام خانوادگی</th>
                    <th>شماره موبایل</th>
					<th>کد ملی</th>
					<th>تعداد سهامدار</th>
                    <th>مبلغ خرید های انجام شده</th>
                    <th>مبلغ سود</th>
				</tr>
            </thead>
            <tbody>
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
	$marketers_query="SELECT * FROM marketers;";
	$marketers_result=$mysqli->query($marketers_query);
	$majmoocount = 0;
	$majmoo = 0;
	$majmoosumcount = 0;
	
	
#############################################################################################
### connect to db ###

	$connection = mysqli_connect('localhost','sunnycart','kosenanat:dD1369','sunnycart') OR die('FAILED...');
	mysqli_set_charset($connection, 'utf8');
	
	function pooya_sms_iterative($pooya_to,$pooya_message,$connection){
			
			
			## $settings_flag agar 0 bood na sms na mail , agar 1 bood yani faghat sms , agar 2 bood yani faghat mail , agar 3 bood yani ham sms 	ham mail (defualt = 3) ##

	$settings_flag_query="SELECT * FROM users WHERE mobile='$pooya_to' LIMIT 1 ; ";
	$settings_flag_result = mysqli_query($connection,$settings_flag_query);
	$settings_flag_row = mysqli_fetch_assoc($settings_flag_result);
	$settings_flag= $settings_flag_row['settings_flag'];
	$settings_sms=false;
	$settings_mail=false;
	if($settings_flag==1){
		$settings_sms=true;
		}elseif($settings_flag==2){
			$settings_mail=true;
		}elseif($settings_flag==3){
			$settings_sms=true;
			$settings_mail=true;
		}
		elseif($settings_flag==0){
			$settings_sms=false;
			$settings_mail=false;
		}
			
			if($settings_sms==true){
			$last_day = time() - (1 * 4 * 60 * 60);
		
			$iterative_query="SELECT * FROM sms WHERE mobile='$pooya_to' AND text='$pooya_message' AND date > $last_day ;";
			$iterative_result = mysqli_query($connection,$iterative_query);
			$iterative_row = mysqli_fetch_assoc($iterative_result);
			$count_sms = mysqli_num_rows($iterative_result);
			
				if($count_sms==0){
					ini_set("soap.wsdl_cache_enabled", "0");
					//$sms_client = new SoapClient('http://87.107.121.54/post/send.asmx?wsdl', array('encoding'=>'UTF-8'));
					$sms_client = new SoapClient('http://melipayamak.ir/post/send.asmx?wsdl', array('encoding'=>'UTF-8'));
					
					$parameters['username'] = "9124077897";
					$parameters['password'] = "3755";
					$parameters['to'] = $pooya_to;
					$parameters['from'] = "2188806627";
					$parameters['text'] =$pooya_message;
					$parameters['isflash'] =false;
					
					$recId = $sms_client->SendSimpleSMS2($parameters)->SendSimpleSMS2Result;
					$date = time();
						
					$mysqli = $connection;
			
					$send_sms_query = "INSERT INTO sms(`id`, `mobile`, `text`, `recId`, `date`) VALUES ('','$pooya_to','$pooya_message','$recId','$date')";
					$send_sms_result = mysqli_query($connection,$send_sms_query);
					return "$pooya_to $pooya_message فرستاده شد!<hr>";
				}else{
					return "به $pooya_to قبلا فرستاده شده است!<hr>";
					}
			}
		}
####################################################################################	
	
	$year = date('Y');
	$month = date('m');
	$day_1 = date('d')-1;
		if(strlen($day_1)==1){$day_1 = '0'.$day_1;}
	$day = date('d');
	$yesterday = $year.'/'.$month.'/'.$day_1;
	$today = $year.'/'.$month.'/'.$day;
	
	
	$yesterdayfa = gregorian_to_jalali($year,$month,$day_1);
		if(strlen($yesterdayfa[1])==1){$yesterdayfa[1] = '0'.$yesterdayfa[1];}
				if(strlen($yesterdayfa[2])==1){$yesterdayfa[2] = '0'.$yesterdayfa[2];}
				$yesterdayfa = $yesterdayfa[0].'/'.$yesterdayfa[1].'/'.$yesterdayfa[2];
			
	$todayfa = gregorian_to_jalali($year,$month,$day);
		if(strlen($todayfa[1])==1){$todayfa[1] = '0'.$todayfa[1];}
				if(strlen($todayfa[2])==1){$todayfa[2] = '0'.$todayfa[2];}
				$todayfa = $todayfa[0].'/'.$todayfa[1].'/'.$todayfa[2];
				
	$from = $yesterday;
	$to = $today;

	$fromfa = $yesterdayfa;
	$tofa = $todayfa;			
				
	
	if(isset($_POST['receptors_submit_sms'])){
		$_POST['receptors_submit_fa'] = 1;
		}
	if(isset($_POST['receptors_submit_fa'])){
							$fromfa = $_POST['fromfa'];
							$tofa = $_POST['tofa'];
					
							
							$yearfromfa = substr($fromfa , 0 , 4);
							$monthfromfa = substr($fromfa , 5 , 2);
							$dayfromfa = substr($fromfa , 8 , 2);
							
							$from = jalali_to_gregorian($yearfromfa,$monthfromfa,$dayfromfa);
								if(strlen($from[1])==1){$from[1] = '0'.$from[1];}
									if(strlen($from[2])==1){$from[2] = '0'.$from[2];}
									$from = $from[0].'/'.$from[1].'/'.$from[2];
							
							$yeartofa = substr($tofa , 0 , 4);
							$monthtofa = substr($tofa , 5 , 2);
							$daytofa = substr($tofa , 8 , 2);
							
							$to = jalali_to_gregorian($yeartofa,$monthtofa,$daytofa);
								if(strlen($to[1])==1){$to[1] = '0'.$to[1];}
									if(strlen($to[2])==1){$to[2] = '0'.$to[2];}
									$to = $to[0].'/'.$to[1].'/'.$to[2];
					
							}
							
										
	
	while($marketers_row=$marketers_result->fetch_assoc()){
		$marketers_id = $marketers_row['id'];
		$marketerssum = 0;
		$marketersamountsum = 0;
		$marketers_count_query = "SELECT * FROM users WHERE marketers_id='$marketers_id' ";
		
				$fromUsers = str_replace('/','-',$from);
				$toUsers = str_replace('/','-',$to);
				$marketers_count_query .= "AND register_date between '$fromUsers' AND '$toUsers' ; ";

		$marketers_count_result=$mysqli->query($marketers_count_query);

		$count = $marketers_count_result->num_rows;

				while($marketers_count_row=$marketers_count_result->fetch_assoc()){
					$id = $marketers_count_row['id'];				
				$cart_query="SELECT * FROM users WHERE id='$id'  ";
				$fromUsers = str_replace('/','-',$from);
				$toUsers = str_replace('/','-',$to);
				
				$cart_query .= "AND register_date between '$fromUsers' AND '$toUsers' ; ";
				
				$cart_result=$mysqli->query($cart_query);
				$cart_row=$cart_result->fetch_assoc();
				//var_dump($cart_row);
				$cart_pri= $cart_row['cart_pri'];
				$cart_sec= $cart_row['cart_sec'];
				$cart_ter= $cart_row['cart_ter'];
				$payerId= $cart_row['payerId'];
				$payerId2= $cart_row['payerId2'];
				$payerId3= $cart_row['payerId3'];
	
	
				
	
				$transaction_query = "SELECT * FROM transaction WHERE ((pan='$cart_pri' AND payerId='$payerId') 
																	OR (pan='$cart_sec' AND payerId='$payerId2') 
																			OR (pan='$cart_ter' AND payerId='$payerId3')) ";
																			
				 
					$transaction_query .= "AND (transaction.settlementDate BETWEEN '$from' AND '$to') ";
		
																	
				$transaction_result = $mysqli->query($transaction_query);
				$sum = 0;
				
				$amountsum = 0;
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
						
						//sahm 80 darsad
						//$amountsum = (($transaction_row['amount']*80)/100)+$amountsum;
						//sahm 100 darsad
							$amountsum = $transaction_row['amount']+$amountsum;
					
					}
					
				}
				//$marketerssum = $marketerssum + $sum;
				$marketerssum = $marketerssum + $amountsum;
				$marketersamountsum = $marketersamountsum + $sum;
				
				//$amountsum=number_format($amountsum,0,'.',',');
				}
				$marketerssum2 = number_format($marketerssum,0,'.',',');
				$marketersamountsum2 = number_format($marketersamountsum,0,'.',',');
				
		echo "
		  <tr>
					<td>$marketers_id</td>
					<td>
					<a href='index.php?page=marketers_stat&id=$marketers_row[id]' target='_blank'><span style='color:blue;' class='glyphicon glyphicon-info-sign'></span></a>
					<a href='index.php?page=users_list&id=$marketers_row[id]' target='_blank'>$marketers_row[first_name] $marketers_row[last_name]</a></td>
					<td>$marketers_row[mobile]</td>
					<td>$marketers_row[melli_code]</td>
					<td>$count</td>
					<td>$marketersamountsum2</td>
					<td>$marketerssum2</td>		
		  </tr>";	
		  $majmoo = $marketerssum + $majmoo;
			$majmoocount = $count + $majmoocount;
			$majmoosumcount = $marketersamountsum + $majmoosumcount;
			
		  if(isset($_POST['receptors_submit_sms'])){
			  if($count>0 &&
			  	($marketers_row['id'] == 3  ||
				 $marketers_row['id'] == 17 ||
				 $marketers_row['id'] == 22 ||
				 $marketers_row['id'] == 16 ||
				 $marketers_row['id'] == 38 ||
				 $marketers_row['id'] == 45 ||
				 $marketers_row['id'] == 63 ||
				 $marketers_row['id'] == 85
				 )
			  ){

$message="همکار گرامی :  $marketers_row[first_name] $marketers_row[last_name]\nعملکرد شما از تاریخ $_POST[fromfa] تا تاریخ $_POST[tofa]  \n $count نفر ثبت نامی و مبلغ خرید های انجام شده  $marketersamountsum2 ریال می باشد.\nwww.scards.ir";

					echo pooya_sms_iterative($marketers_row['mobile'],$message,$connection);
					//echo pooya_sms_iterative('09361946269',$message,$connection);
			  }
			}
	}
	
	$majmoo = number_format($majmoo,0,'.',',');
	$majmoosumcount = number_format($majmoosumcount,0,'.',',');
	
?>
</tbody>
</table>
<?php  
	echo	"مجموع تعداد سهامدار : <span style='color:green;'>$majmoocount</span><br><br>";
	echo	"مجموع مبلغ خرید های انجام شده : <span style='color:green;'>$majmoosumcount</span>ریال <br><br>";
	echo	"مجموع مبلغ سود : <span style='color:green;'>$majmoo</span>ریال <br><br>";
	
?>
<form method="post" role="form" class="form form-inline">
	<label for="fromfa"> از تاریخ  : </label><input type="text" class="form-control" name="fromfa" value="<?php echo $fromfa; ?>">
    <label for="tofa"> تا تاریخ  : </label><input type="text" class="form-control" name="tofa" value="<?php echo $tofa; ?>">
    <input type="submit" name="receptors_submit_fa" value="جستجو" class="form-control btn btn-md btn-primary">
    <input type="submit" name="receptors_submit_sms" value="ارسال اس ام اس" class="form-control btn btn-md btn-warning">
</form>
<br>
<p>ارسال اس ام اس (3 - 17 - 22 - 16 - 38 - 45 - 63 - 85 )</p>