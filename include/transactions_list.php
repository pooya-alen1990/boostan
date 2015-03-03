<?php if($transactions_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست خرید ها</h3>
خرید های دیروز
<div class="table-responsive">
            <table class="table table-striped table-hover table-bordered tablesorter">
            	<thead>
                <tr>
					<th>ردیف</th>
                    <th>شهر</th>
                    <th>شماره پایانه</th>
					<th>نام مغازه</th>
                    <th>مبلغ سود</th>
                    <th>شماره کارت</th>
                    <th>شناسه واریز</th>
                    <th>صاحب حساب</th>
                    <th>بازاریاب</th>
					<th>موبایل</th>
                    <th>تاریخ تراکنش</th>
					<th>ساعت تراکنش</th>
				</tr>
                </thead>
                <tbody>
<?php
include('jdf.php');
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
								,users.marketers_id
								 FROM transaction 
									INNER JOIN receptors
											ON transaction.terminalId = receptors.terminal_id
									INNER JOIN users
											ON transaction.pan = users.cart_pri AND transaction.payerId = users.payerId
											OR transaction.pan = users.cart_sec AND transaction.payerId = users.payerId2
											OR transaction.pan = users.cart_ter AND transaction.payerId = users.payerId3
									WHERE 1 = 1 ";
		
	$from = $yesterday;
	$to = $today;

	$fromfa = $yesterdayfa;
	$tofa = $todayfa;
	
	/*if(isset($_POST['from'])){
		$from = $_POST['from'];
		$to = $_POST['to'];
		}*/
		
		##################################
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$find_query = "SELECT id,mobile FROM users WHERE id='$id' ";
			$find_result = $mysqli->query($find_query);
			$mobile_find = $find_result->fetch_assoc();
			$_POST['mobile'] = $mobile_find['mobile'];
			$_POST['fromfa'] = '1393/01/01';
			$_POST['tofa'] = '1394/01/01';
			$_POST['receptors_submit_fa'] = 1;
			}
		##################################
		##################################
		if(isset($_GET['receptor_id_all'])){
			$receptor_id = $_GET['receptor_id_all'];
			
			$find_query = "SELECT receptor_name FROM receptors WHERE id='$receptor_id' ";
			$find_result = $mysqli->query($find_query);
			$find_row = $find_result->fetch_assoc();
			$_POST['receptor_name_ajax'] = $find_row['receptor_name'];
			$_POST['fromfa'] = '1393/01/01';
			$_POST['tofa'] = '1394/01/01';
			$_POST['receptors_submit_fa'] = 1;
			
			}
		##################################
		##################################
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
		echo "
		
		  <tr>
					<td>$i</td>
					<td>$transactions_row[city]</td>
					<td>$transactions_row[terminalId]</td>
					<td>$transactions_row[receptor_name]</td>
					<td>$transactions_row[amount]</td>
					<td dir='ltr'>$transactions_row[pan]</td>
					<td>$transactions_row[payerId]</td>";
					if($test=='ok'){
						echo "
						
						<td style='color:green;'>
						<a target='_blank' title='نمایش پیگیری' href='index.php?page=follow_list&user_id=$transactions_row[id]'><span class='glyphicon glyphicon-phone-alt' style='color:green;'></span></a>
						$transactions_row[first_name] $transactions_row[last_name]</td>";}
					else{
						echo "<td>
						<a target='_blank' title='نمایش پیگیری' href='index.php?page=follow_list&user_id=$transactions_row[id]'><span class='glyphicon glyphicon-phone-alt' style='color:green;'></span></a>
						<a target='_blank' title='نمایش سهام' href='index.php?page=stock_list&id=$transactions_row[id]'><span class='glyphicon glyphicon-paperclip' style='color:red;'></span></a>
						<a href='index.php?page=transactions_list&id=$transactions_row[id]' target='_blank'>$transactions_row[first_name] $transactions_row[last_name]</a></td>";}
					echo "
					<td>$transactions_row[marketers_id]</td>
					<td>$transactions_row[mobile]</td>
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
echo "مجموع سود : <span style='color:green;'>$sum2</span>ریال <br><br>";  ?>
</div>
<?php echo 'تعداد خرید اولی ها : <span style="color:green;">'.$testcount.'</span><br><br>'; ?>
<!--<form method="post" role="form" class="form form-inline">
	<label for="from"> از تاریخ میلادی : </label><input type="text" class="form-control" name="from" value="<?php// echo $from; ?>">
    <label for="to"> تا تاریخ میلادی : </label><input type="text" class="form-control" name="to" value="<?php// echo $to; ?>">
</form>
<hr style="margin:20px 0;">-->
<form method="post" role="form" class="form form-inline">
	<label for="fromfa"> از تاریخ  : </label><input type="text" class="form-control" name="fromfa" value="<?php echo $fromfa; ?>">
    <label for="tofa"> تا تاریخ  : </label><input type="text" class="form-control" name="tofa" value="<?php echo $tofa; ?>">

<hr style="margin:20px 0;">
	<label for="receptor_name">جستجو بر اساس نام فروشگاه : </label>
    <select type="text" class="form-control" name="receptor_name">
    <option value="all">همه</option>
			<?php 
			
            $receptors_query = "SELECT * FROM receptors ORDER BY receptor_name ASC ; ";
                        $receptors_result = $mysqli->query($receptors_query);                                
                        while($receptors_row = $receptors_result->fetch_assoc()){
                                echo "<option> $receptors_row[receptor_name] </option>";	      			
                        }
            ?>
	</select>
    <input type="text" name="receptor_name_ajax" id="receptor_name_ajax" class="form-control"><br><br>
    <span id="show_result"></span>
<hr style="margin:20px 0;">
	<label for="from">جستجو بر اساس موبایل سهامدار : </label><input type="text" class="form-control" name="mobile">
    <input type="submit" name="receptors_submit_fa" value="جستجو" class="form-control btn btn-md btn-primary">
</form>
<script src="js/jquery.js"></script>
<script>
		function test(){
			$(document).ready(function() {
                	$(".test").click(function() {
               			 $("#receptor_name_ajax").val($(this).attr('value'));
            		});
            });
			
		}
</script>
<script>
$(document).ready(function() {
	var keyword = $("#receptor_name_ajax").val();
			$.post('include/ajax_list.php',{ keyword:keyword },function(data){
				$("#show_result").html(data);
				test();
			});	
    $("#receptor_name_ajax").keyup(function() {
        	var keyword = $("#receptor_name_ajax").val();
			$.post('include/ajax_list.php',{ keyword:keyword },function(data){
				$("#show_result").html(data);
				test();
				});
		
			
		
    });
});
</script>
<?php
	$transaction_count = $i-1;
	$diagram_query_find = "SELECT * FROM diagram WHERE day='$fromfa' ; ";
                        $diagram_find_result = $mysqli->query($diagram_query_find); 
						$diagram_find_row = $diagram_find_result->fetch_assoc();                            
                        if(!$diagram_find_row && $testcount != 0){
								$diagram_query_insert = "INSERT INTO `diagram`(`id`, `day`, `transaction_count`, `transaction_amount`, `active_count`)
																 VALUES ('','$fromfa','$transaction_count','$sum','$testcount')";
                       			$diagram_result_insert = $mysqli->query($diagram_query_insert);
							}
?>
<?php							
	$diagram_query = "SELECT * FROM ( SELECT * FROM diagram ORDER BY day DESC LIMIT 10 ) AS r ORDER BY day ASC ; ";
    $diagram_result = $mysqli->query($diagram_query);

        $labels = array();
        $data   = array();
		$data2   = array();
    
        while ($diagram_row = $diagram_result->fetch_assoc()) {
            $labels[] = $diagram_row["day"];
            $data[]   = $diagram_row["transaction_count"];
			$data2[]   = $diagram_row["transaction_amount"];
			$data3[]   = $diagram_row["active_count"];
        }

        // Now you can aggregate all the data into one string
        $data_string = "[" . join(", ", $data) . "]";
		$data_string2 = "[" . join(", ", $data2) . "]";
		$data_string3 = "[" . join(", ", $data3) . "]";
        $labels_string = "['" . join("', '", $labels) . "']";
?>
<script src="js/jquery.js"></script>
<script src="js/RGraph.common.core.js" ></script>
<script src="js/RGraph.line.js" ></script>
    <hr><hr>
    <div class="col-sm-12" style="padding:0">
    <h4 class="sub-header">نمودار تعداد تراکنش ها</h4>
    <canvas id="cvs" width="1000" height="250" style="width:90%">[No canvas support]</canvas>
    <script>
        chart = new RGraph.Line('cvs', <?php print($data_string) ?>)
            .set('background.grid.autofit', true)
            .set('gutter.left', 75)
            .set('gutter.right', 25)
            .set('hmargin', 10)
            .set('tickmarks', 'endcircle')
            .set('labels', <?php print($labels_string) ?>)
            .draw();
			
    </script>
    </div>	
    <div class="col-sm-12" style="padding:0">
    <hr>
    <h4 class="sub-header">نمودار مبلغ سود</h4>
	<canvas id="cvs2" width="1000" height="250" style="width:90%">[No canvas support]</canvas>
	<script>
    		chart2 = new RGraph.Line('cvs2', <?php print($data_string2) ?>)
            .set('background.grid.autofit', true)
            .set('gutter.left', 75)
            .set('gutter.right', 25)
            .set('hmargin', 10)
            .set('tickmarks', 'endcircle')
			.set('chart.colors', ['blue','yellow'])
            .set('labels', <?php print($labels_string) ?>)
            .draw();
    </script>
    </div> 
    <div class="col-sm-12" style="padding:0">
    <hr>
    <h4 class="sub-header">نمودار تعداد خرید اولی ها</h4>
    <canvas id="cvs3" width="1000" height="250" style="width:90%">[No canvas support]</canvas>
    <script>
    		chart3 = new RGraph.Line('cvs3', <?php print($data_string3) ?>)
            .set('background.grid.autofit', true)
            .set('gutter.left', 75)
            .set('gutter.right', 25)
            .set('hmargin', 10)
            .set('tickmarks', 'endcircle')
			.set('chart.colors', ['green','yellow'])
            .set('labels', <?php print($labels_string) ?>)
            .draw();
    </script>
    </div>
