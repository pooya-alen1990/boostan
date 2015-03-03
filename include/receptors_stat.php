<?php if($receptors_stat == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">آمار پذیرندگان تهران</h3>

    <table class="table table-striped table-hover table-bordered tablesorter" id="testTable">
    		<thead>
				<tr>
                	  <th>شهر</th>
                      <th>نام پذیرنده</th>
                      <th class="warning">تعداد خرید دیروز</th>
                      <th class="success">سود دیروز</th>
                      <th class="info">تعداد خرید اولی دیروز</th>
                      <th>عملکرد نسبت به روز گذشته</th>
				</tr>
            </thead>
            <tbody>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors','1');
	date_default_timezone_set('Asia/Tehran');
	include('jdf.php');
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
	$day_2 = date('d')-2;
		if(strlen($day_1)==1){$day_1 = '0'.$day_1;}
		if(strlen($day_2)==1){$day_2 = '0'.$day_2;}
	$day = date('d');
	$yesterday = $year.'/'.$month.'/'.$day_1;
	$yesterday_1 = $year.'/'.$month.'/'.$day_2;
	$today = $year.'/'.$month.'/'.$day;
	
	$yesterdayfa = gregorian_to_jalali($year,$month,$day_1);
		if(strlen($yesterdayfa[1])==1){$yesterdayfa[1] = '0'.$yesterdayfa[1];}
				if(strlen($yesterdayfa[2])==1){$yesterdayfa[2] = '0'.$yesterdayfa[2];}
				$yesterdayfa = $yesterdayfa[0].'/'.$yesterdayfa[1].'/'.$yesterdayfa[2];
				
	$yesterday_1fa = gregorian_to_jalali($year,$month,$day_2);
		if(strlen($yesterday_1fa[1])==1){$yesterday_1fa[1] = '0'.$yesterday_1fa[1];}
				if(strlen($yesterday_1fa[2])==1){$yesterday_1fa[2] = '0'.$yesterday_1fa[2];}
				$yesterday_1fa = $yesterday_1fa[0].'/'.$yesterday_1fa[1].'/'.$yesterday_1fa[2];
				
				
			
	$todayfa = gregorian_to_jalali($year,$month,$day);
		if(strlen($todayfa[1])==1){$todayfa[1] = '0'.$todayfa[1];}
				if(strlen($todayfa[2])==1){$todayfa[2] = '0'.$todayfa[2];}
				$todayfa = $todayfa[0].'/'.$todayfa[1].'/'.$todayfa[2];
				
	$fromfa = $yesterdayfa;
	$tofa = $todayfa;
	
	if(isset($_POST['leader_search'])){
		$fromfa = $_POST['fromfa'];
		$tofa = $_POST['tofa'];	
		}
			
############### START FUNCTION ##############
	function test($id,$from_function,$to_function){
$i = 0 ;
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

								 FROM transaction 
									INNER JOIN receptors
											ON transaction.terminalId = receptors.terminal_id


									WHERE 1 = 1 ";
	
	//$transactions_query .= "AND  (receptors.city = 'تهران' ";
	
			
	$from = $yesterday;
	$to = $today;
	

		
		$fromfa = $from_function;
		$tofa = $to_function;

		
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
	

	//$fromfa = $yesterdayfa;
	//$tofa = $todayfa;

		##################################
		$_GET['receptor_id'] = $id;
		if(isset($_GET['receptor_id'])){
			$receptor_id = $_GET['receptor_id'];
			
			$find_query = "SELECT receptor_name FROM receptors WHERE id='$receptor_id' ";
			$find_result = $mysqli->query($find_query);
			$find_row = $find_result->fetch_assoc();
			$_POST['receptor_name_ajax'] = $find_row['receptor_name'];
			$_POST['fromfa'] = $fromfa;
			$_POST['tofa'] = $tofa;
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
	
		
		
		
		if(isset($_POST['receptor_name']) && $_POST['receptor_name']!='all'){
		$receptor_name = $_POST['receptor_name'];
		$transactions_query .= "AND (receptors.receptor_name = '$receptor_name') ";
		}
		if(isset($_POST['receptor_name_ajax']) && !empty($_POST['receptor_name_ajax'])){
		$receptor_name_ajax = $_POST['receptor_name_ajax'];
		$transactions_query .= "AND (receptors.receptor_name = '$receptor_name_ajax') ";
		}
		if(isset($_POST['mobile']) && !empty($_POST['mobile'])){
		$mobile = $_POST['mobile'];
		$transactions_query .= "AND (users.mobile = '$mobile') ";
		}
		
	$transactions_query .= "ORDER BY transaction.settlementDate , transaction.settlementTime ";

	$transactions_result = $mysqli->query($transactions_query);
	$testcount = 0 ;
	while($transactions_row = $transactions_result ->fetch_assoc()){
		###########################################################################################################
if(false){
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
}
		
		###########################################################################################################
		
		$date = $transactions_row['settlementDate'];
		
		$yearfa = substr($date , 0 , 4);
		$monthfa = substr($date , 5 , 2);
		$dayfa = substr($date , 8 , 2);
		
		$date = gregorian_to_jalali($yearfa,$monthfa,$dayfa,'/');

		$sum = $sum + $transactions_row['amount'];		
		$date_fa = $date;
		$i++;
		}

		return "$i/$sum/$testcount";
}
################ END FUNCTION ###############


		
		$sum_tedad = 0 ; $sum_mablagh = 0 ;$sum_kharidavvali = 0 ;
		$avg_tedad = 0 ; $avg_mablagh = 0 ;$avg_kharidavvali = 0 ;
		
	

		$receptor_query="SELECT * FROM receptors WHERE activate = '1'  AND  receptors.city = 'تهران' ; ";
		$receptor_result=$mysqli->query($receptor_query);
		$receptor_count = $receptor_result->num_rows;

		$subTable = ' ';
				
				while($receptor_row=$receptor_result->fetch_assoc()){
					
					$show = explode('/',test($receptor_row['id'],$fromfa,$tofa));
					
					$show_1 = explode('/',test($receptor_row['id'],$yesterday_1fa,$yesterday_1fa));

					
					$sum_tedad = $sum_tedad + $show[0];
					$sum_mablagh = $sum_mablagh + $show[1];
					$sum_kharidavvali = $sum_kharidavvali + $show[2];	
					
					//$show_dotted = number_format($show['1'],0,'.',',');
					$show_dotted = $show['1'];
					$sum_mablagh_dotted = number_format($sum_mablagh,0,'.',',');
					
					
					if($show['1']>$show_1['1']){
						$flag = "<span style='color:green;' class='glyphicon glyphicon-arrow-up'></span>";
						}elseif($show['1']<$show_1['1']){
						$flag = "<span style='color:red;' class='glyphicon glyphicon-arrow-down'></span>";	
							}else{
						$flag = "<span style='color:blue;' class='glyphicon glyphicon-minus'></span>";	
							}

				$subTable .= "<tr>
									<td  class='warning'>
										$receptor_row[city]
									</td>
									<td>
										<a target='_blank' href='index.php?page=transactions_list&receptor_id=$receptor_row[id]'>
												$receptor_row[receptor_name]
										</a>
									</td>
									<td  class='warning'>
										$show[0]
									</td>
									<td  class='success'>
										$show_dotted
									</td>
									<td  class='info'>
										$show[2]
									</td>
									<td>
										$flag
									</td>
							 </tr>";
				
				}
				
					$subTable .= "<tr>
										<td></td>
										<td>جمع کل</td>
										<td>$sum_tedad</td>
										<td>$sum_mablagh_dotted</td>
										<td>$sum_kharidavvali</td>
										<td></td>
								 </tr>";
										
					$avg_tedad = round($sum_tedad/$receptor_count);
					$avg_mablagh = round($sum_mablagh/$receptor_count);
					$avg_kharidavvali = round($sum_kharidavvali/$receptor_count);
					$avg_mablagh_dotted = number_format($avg_mablagh,0,'.',',');				 
								 
					$subTable .= "<tr>
										<td></td>
										<td>میانگین</td>
										<td>$avg_tedad</td>
										<td>$avg_mablagh_dotted</td>
										<td>$avg_kharidavvali</td>
								 </tr>";
								 
								 		 
							 
		$subTable .= '</table>';
				
		  echo $subTable;	
		  
	
	
?>
<hr>
<?php if($users_list == false){die();} ?>
<form method="post" role="form" class="form form-inline">
	<label for="fromfa"> از تاریخ  : </label><input type="text" class="form-control" name="fromfa" value="<?php echo $fromfa; ?>">
    <label for="tofa"> تا تاریخ  : </label><input type="text" class="form-control" name="tofa" value="<?php echo $tofa; ?>">
    <input type="submit" name="leader_search" value="جستجو" class="form-control btn btn-md btn-primary">
</form>