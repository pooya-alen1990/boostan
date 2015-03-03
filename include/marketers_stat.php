<?php if($marketers_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">عملکرد یک ماه گذشته بازاریاب</h3>
    <table class="table table-striped table-hover table-bordered tablesorter">
    		<thead>
				<tr>
					<th>ردیف</th>
					<th>نام و نام خانوادگی</th>
                    <th>شماره موبایل</th>
					<th>کد ملی</th>
					<th>تعداد سهامدار</th>
                    <th>مبلغ خرید های انجام شده</th>
                    <th>مبلغ سود</th>
                    <th>بازه زمانی</th>
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
	
	
function marketers_stat($marketersId,$i,$mysqli){	
	$marketers_query="SELECT * FROM marketers WHERE id = '$marketersId' ;";
	$marketers_result=$mysqli->query($marketers_query);	
	
	$year = date('Y');
	$month = date('m');
	$day_1 = date('d')-$i;
	
		if(strlen($day_1)==1){$day_1 = '0'.$day_1;}
	$day = date('d')-($i-1);
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
													
	
		$marketers_row=$marketers_result->fetch_assoc();
		$marketers_id = $marketers_row['id'];
		$marketerssum = 0;
		$marketersamountsum = 0;
		$marketers_count_query = "SELECT * FROM users WHERE marketers_id = '$marketersId' ";
		
				$fromUsers = str_replace('/','-',$from);
				$toUsers = str_replace('/','-',$to);

				$marketers_count_query .= "AND register_date between '$fromUsers' AND '$toUsers' ; ";
				
					
		$marketers_count_result=$mysqli->query($marketers_count_query);
		$marketers_count_row=$marketers_count_result->fetch_assoc();
		$count = $marketers_count_result->num_rows;

				while($marketers_count_row=$marketers_count_result->fetch_assoc()){
					$id = $marketers_count_row['id'];				
					
				$cart_query="SELECT * FROM users WHERE id='$id'  ";
				
				$fromUsers = str_replace('/','-',$from);
				$toUsers = str_replace('/','-',$to);
				
				$cart_query .= "AND register_date between '$fromUsers' AND '$toUsers' ; ";
				
				$cart_result=$mysqli->query($cart_query);
				$cart_row=$cart_result->fetch_assoc();
				$cart_pri= $cart_row['cart_pri'];
				$cart_sec= $cart_row['cart_sec'];
				$cart_ter= $cart_row['cart_ter'];
				$payerId= $cart_row['payerId'];
				$payerId2= $cart_row['payerId2'];
				$payerId3= $cart_row['payerId3'];
		
	
				$transaction_query = "SELECT * FROM transaction WHERE ((pan='$cart_pri' AND payerId='$payerId') 
																	OR (pan='$cart_sec' AND payerId='$payerId2') 
																			OR (pan='$cart_ter' AND payerId='$payerId3')) ";
																			
				 
				//$transaction_query .= "AND (transaction.settlementDate BETWEEN '$from' AND '$to') ";
		
																	
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
				
		return "
		  <tr>
					<td>$i</td>
					<td><a href='index.php?page=users_list&id=$marketers_row[id]' target='_blank'> $marketers_id - $marketers_row[first_name] $marketers_row[last_name]</a></td>
					<td>$marketers_row[mobile]</td>
					<td>$marketers_row[melli_code]</td>
					<td>$count</td>
					<td>$marketersamountsum2</td>
					<td>$marketerssum2</td>
					<td>$fromfa - $tofa</td>		
		  </tr>";	
}
		  


for($i = 1 ; $i<32 ;$i++){
	echo marketers_stat($_GET['id'],$i,$mysqli);
	}
	
?>
</tbody>
</table>