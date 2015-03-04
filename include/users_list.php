<?php if($users_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست مالکین</h3>
<div class="table-responsive text-center">
            <table class="table table-striped table-hover table-bordered tablesorter">
               <thead>
                <tr>
					<th>ردیف</th>
                    <th>شهر</th>
					<th>نام و نام خانوادگی</th>
                    <th>جنسیت</th>
                    <th>شماره موبایل</th>
                    <th style="width:200px;">اطلاعات کارت</th>
					<th>تاریخ ثبت نام</th>
                    <th>تعداد تراکنش</th>
					<th>مجموع خرید</th>
					<th>مجموع سود</th>
                    <th>بازاریاب</th>
				</tr>
                </thead>
                <tbody>
<?php
include('jdf.php');
$i = 1;

	$count_users="SELECT COUNT(id) FROM users;";
	$count_users_result=$mysqli->query($count_users);
	$count_users_row=$count_users_result->fetch_assoc();
	echo 'تعداد کل سهامداران : '.$count_users_row['COUNT(id)'];
		
############ pagination ################

$per_page = 300;

if(isset($_GET['pages'])){
	$pages = ($_GET['pages']-1);
	$start = $pages * $per_page;
	}else{
	$pages = 0;
	$start = $pages;	
		}

$page_count = ceil($count_users_row['COUNT(id)'] / $per_page);
########################################

	
	$every_body_query="SELECT * FROM users WHERE 1=1 ";
	if(isset($_GET['id'])){
	$id_passed = $_GET['id'];
	$every_body_query .= "AND marketers_id='$id_passed' ";
	}else{
	
	$every_body_query .= " LIMIT $start,$per_page ";
	}
	
	$every_body_result=$mysqli->query($every_body_query);
	
	while($every_body_row=$every_body_result->fetch_assoc()){
	### Gozaresh giri ###
	$id=$every_body_row['id'];
	$register_date = substr($every_body_row['register_date'],0,10);
	$register_time = substr($every_body_row['register_date'],10,10);
	$register_date = $every_body_row['register_date'];
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
	$sum=number_format($sum,0,'.',',');
	$amountsum=number_format($amountsum,0,'.',',');
	
	if(empty($every_body_row['cart_pri'])){
		$every_body_row['cart_pri'] = 'کارت اول ندارد';
		}else{
		$every_body_row['cart_pri'] = "$every_body_row[cart_pri] <span style='color:red;'> : </span> $every_body_row[payerId]";	
			}
			
	if(empty($every_body_row['cart_sec'])){
		$every_body_row['cart_sec'] = 'کارت دوم ندارد';
		}else{
		$every_body_row['cart_sec'] = "$every_body_row[cart_sec] <span style='color:red;'> : </span> $every_body_row[payerId2]";	
			}
	if(empty($every_body_row['cart_ter'])){
		$every_body_row['cart_ter'] = 'کارت سوم ندارد';
		}else{
		$every_body_row['cart_ter'] = "$every_body_row[cart_ter] <span style='color:red;'> : </span> $every_body_row[payerId3]";	
			}		
			
			
			$count_follow_query = "SELECT COUNT(id) FROM follow WHERE user_id='$every_body_row[id]' ;";
			$count_follow_result = $mysqli->query($count_follow_query);
			$count_follow_row = $count_follow_result->fetch_assoc();


			$reject_query = "SELECT * FROM follow WHERE user_id = '$every_body_row[id]' ; ";
			$reject_result = $mysqli->query($reject_query);
			$reject_row = $reject_result->fetch_assoc();

			$rejection = "عدم پاسخگویی.<br>";
				$color = "green";
				if(strpos($reject_row['explain'],$rejection) !== false){
					$color = "red";
					}
			
	echo "
		  <tr>
					<td>$i</td>
					<td>$every_body_row[city]</td>
					<td>
						<a target='_blank' title='ویرایش اطلاعات' href='index.php?page=users_edit&user_mobile=$every_body_row[mobile]'><span class='glyphicon glyphicon-pencil' style='color:blue;'></span></a>
						<a target='_blank' title='نمایش سهام' href='index.php?page=stock_list&id=$every_body_row[id]'><span class='glyphicon glyphicon-paperclip' style='color:red;'></span></a>
						<a href='index.php?page=transactions_list&id=$every_body_row[id]' target='_blank'>$every_body_row[first_name] $every_body_row[last_name]</a><br>
						<a target='_blank' title='نمایش پیگیری' href='index.php?page=follow_list&user_id=$every_body_row[id]'><span class='glyphicon glyphicon-phone-alt' style='color:".$color.";'></span> پیگیری <span class='badge'>".$count_follow_row['COUNT(id)']."</span></a>
					</td>
					<td>$every_body_row[gender]</td>
					<td>$every_body_row[mobile]</td>
					<td dir='ltr'>
						$every_body_row[cart_pri]<br>
						$every_body_row[cart_sec]<br>
						$every_body_row[cart_ter]<br>
					</td>
					<td>$register_date <br> $register_time</td>
					<td>$count_users_tarakonesh</td>
					<td>$sum</td>
					<td>$amountsum</td>
					<td>$every_body_row[marketers_id]</td>		
		  </tr>";
	$i++;
}
?>
</tbody>
</table>
<ul class="pagination pagination-md">
<?php
if(!isset($_GET['id'])){
		if($_GET['pages']>1){
					$prev = $_GET['pages']-1;
				}else{
					$prev = 1;
					}
			
		if($_GET['pages']<=($page_count-1)){
					$next = $_GET['pages']+1;
				}else{
					$next = $page_count;
					}
			
		  echo "<li><a href='index.php?page=users_list&pages=1'>اولین</a></li>";	
		  echo "<li><a href='index.php?page=users_list&pages=$prev'>قبلی &raquo;</a></li>";
		  for($i=1;$i<=$page_count;$i++){
			  if($i == $_GET['pages']){$activepage = 'active';}else{$activepage = ' ';}
			echo "<li class='$activepage'><a href='index.php?page=users_list&pages=$i'>$i</a></li>";
		  }
		  echo "<li><a href='index.php?page=users_list&pages=$next'>&laquo; بعدی</a></li>";
		  echo "<li><a href='index.php?page=users_list&pages=".$page_count."'>آخرین</a></li>";
}
?>  
</ul>
</div>