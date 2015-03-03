<?php if($unknown_list_tabriz == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست نا معلوم های تبریز</h3>
معوقات دیروز تبریز
<div class="table-responsive">
            <table class="table table-striped table-hover table-bordered tablesorter">
            	<thead>
                <tr>
					<th>ردیف</th>
                    <th>شهر</th>
                    <th>شماره پایانه</th>
					<th>نام مغازه</th>
                    <th>مبلغ سود</th>
                    <th>تعداد خرید</th>
                    <th>شماره کارت</th>
                    <th>شناسه واریز</th>
                    <th>صاحب حساب</th>
                    <th>تاریخ تراکنش</th>
					<th>ساعت تراکنش</th>
				</tr>
                </thead>
                <tbody>
<?php
include('include/jdf.php');
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
	

	$transactions_query = "SELECT 
								 transaction.amount
								,transaction.pan
								,transaction.settlementDate
								,transaction.settlementTime
								,transaction.payerId
								,transaction.terminalId
								,receptors.receptor_name
								,receptors.city
								,users.id
								,users.first_name
								,users.last_name
								,users.mobile
								 FROM transaction 
									INNER JOIN receptors
											ON transaction.terminalId = receptors.terminal_id
									LEFT JOIN users
											ON transaction.pan = users.cart_pri AND transaction.payerId = users.payerId
											OR transaction.pan = users.cart_sec AND transaction.payerId = users.payerId2
											OR transaction.pan = users.cart_ter AND transaction.payerId = users.payerId3
									WHERE (users.cart_pri is NULL OR users.cart_sec is NULL OR users.cart_ter is NULL) AND receptors.city='تبریز' ";
	$from = $yesterday;
	$to = $today;

	$fromfa = $yesterdayfa;
	$tofa = $todayfa;
	
	##################################
		if(isset($_GET['pan'])){
			$pan = $_GET['pan'];
			$_POST['fromfa'] = '1393/01/01';
			$_POST['tofa'] = '1394/01/01';
			$_POST['receptors_submit_fa'] = 1;
			}
	##################################
		
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
		$transactions_query .= "AND (transaction.settlementDate BETWEEN '$from' AND '$to') ";
	
		if(isset($pan) && !empty($pan)){
		$transactions_query .= "AND (transaction.pan = '$pan') ";
		}
		
	$transactions_query .= "ORDER BY transaction.settlementDate , transaction.settlementTime ";
	$transactions_result = $mysqli->query($transactions_query);
	$testcount = 0 ;
	while($transactions_row = $transactions_result ->fetch_assoc()){
		###########################################################################################################
		$test = '';
	
	$cart_query="SELECT * FROM users WHERE id='$transactions_row[id]';";
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
	$sum1 = 0;
	$amountsum1 = 0;
	$count_users_tarakonesh = 0;
	while($transaction_row=$transaction_result->fetch_assoc()){
		if($transaction_row['accountNumber']=='4975553214'){
			
			$terminalid = $transaction_row['terminalId'];
			$terminalid_query="SELECT * FROM receptors WHERE terminal_id='$terminalid'; ";
			$terminalid_result=$mysqli->query($terminalid_query);
			$terminalid_row=$terminalid_result->fetch_assoc();
			
			if($terminalid_row['discount'] != 0){
			$amount1 = ($transaction_row['amount']*100)/$terminalid_row['discount'];
			}
			//echo '<pre>';
			//print_r($transaction_row);
			//echo '</pre>';
			$sum1 = $sum1 + $amount1;
		if($sum1 != 0){
			$count_users_tarakonesh++;
			}
			//sahm 80 darsad
			//$amountsum = (($transaction_row['amount']*80)/100)+$amountsum;
			//sahm 100 darsad
				$amountsum1 = $transaction_row['amount']+$amountsum1;		
		}		
	}
		  ####### sahamdarane faal ###########
		if($count_users_tarakonesh == 1){
			$test = 'ok';
			$testcount++;
			}

		
		###########################################################################################################
		
		$date = $transactions_row['settlementDate'];
		
		$yearfa = substr($date , 0 , 4);
		$monthfa = substr($date , 5 , 2);
		$dayfa = substr($date , 8 , 2);
		
		$date = gregorian_to_jalali($yearfa,$monthfa,$dayfa,'/');

		$sum = $sum + $transactions_row['amount'];		
		$date_fa = $date;
		
		if(strlen($transactions_row['pan'])==19){
				$type = '<span style="color:orange;">کارت تجارت</span>';
				}else{
					$type = '<span style="color:red;">معلوم نیست</span>';
			}
			
			####### count query ##########
			$count_query = "SELECT 
								 transaction.amount
								,transaction.pan
								,transaction.settlementDate
								,transaction.settlementTime
								,transaction.payerId
								,transaction.terminalId
								,receptors.receptor_name
								,receptors.city
								,users.id
								,users.first_name
								,users.last_name
								,users.mobile
								 FROM transaction 
									INNER JOIN receptors
											ON transaction.terminalId = receptors.terminal_id
									LEFT JOIN users
											ON transaction.pan = users.cart_pri AND transaction.payerId = users.payerId
											OR transaction.pan = users.cart_sec AND transaction.payerId = users.payerId2
											OR transaction.pan = users.cart_ter AND transaction.payerId = users.payerId3
									WHERE (users.cart_pri is NULL OR users.cart_sec is NULL OR users.cart_ter is NULL) AND transaction.pan='$transactions_row[pan]'  AND receptors.city='تبریز' ";
									
									
			$count_result = $mysqli->query($count_query);
			$count_row = $count_result->fetch_assoc();
			$count = $count_result->num_rows;
			##############################
			
		echo "
		
		  <tr>
					<td>$i</td>
					<td>$transactions_row[city]</td>
					<td>$transactions_row[terminalId]</td>
					<td>$transactions_row[receptor_name]</td>
					<td>$transactions_row[amount]</td>
					<td>$count</td>
					<td dir='ltr'><a href='index.php?page=unknown_list_tabriz&pan=$transactions_row[pan]' target='_blank'>$transactions_row[pan]</a></td>
					<td>$transactions_row[payerId]</td>
					<td>$type</td>
					<td>$date_fa</td>
					<td>$transactions_row[settlementTime]</td>		
		  </tr>";
		$i++;
		}

			
?>
</tbody>
</table>
<?php	
$sum2=number_format($sum,0,'.',',');
echo "مجموع مبالغ معوقه : <span style='color:green;'>$sum2</span>ریال <br><br>";  ?>
</div>
<!--<form method="post" role="form" class="form form-inline">
	<label for="from"> از تاریخ میلادی : </label><input type="text" class="form-control" name="from" value="<?php// echo $from; ?>">
    <label for="to"> تا تاریخ میلادی : </label><input type="text" class="form-control" name="to" value="<?php// echo $to; ?>">
</form>
<hr style="margin:20px 0;">-->
<form method="post" role="form" class="form form-inline">
	<label for="fromfa"> از تاریخ  : </label><input type="text" class="form-control" name="fromfa" value="<?php echo $fromfa; ?>">
    <label for="tofa"> تا تاریخ  : </label><input type="text" class="form-control" name="tofa" value="<?php echo $tofa; ?>">
    <input type="submit" name="receptors_submit_fa" value="جستجو" class="form-control btn btn-md btn-primary">
</form>