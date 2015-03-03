<?php if($receptors_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست پذیرندگان</h3>
<div class="table-responsive">
            <table class="table table-striped table-hover table-bordered tablesorter">
               <thead>
                <tr>
					<th>ردیف</th>
                    <th>شهر</th>
					<th>نام و نام خانوادگی</th>
                    <th>نام فروشگاه</th>
                    <th>شماره پایانه</th>
                    <th>درصد تخفیف</th>
					<th>شماره موبایل</th>
					<th>شماره تلفن</th>
					<th style="width:194px;">آدرس</th>
                    <th>مبلغ سود</th>
                    <th>مبلغ خرید</th>
                    <th>تعداد خرید</th>
                    <!--<th>تعداد ثبت نامی</th>-->
                    <th>وضعیت</th>               
				</tr>
               </thead>
               <tbody>
<?php
include('jdf.php');
error_reporting(E_ALL);
ini_set('display_errors','1');
date_default_timezone_set('Asia/Tehran');
$i = 1 ;
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
	### Gozaresh giri ###
	$terminalId=$every_receptor_row['terminal_id'];
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
	$sum_1=number_format($sum,0,'.',',');
	
	if($every_receptor_row['activate']=='1'){$every_receptor_row['activate'] = '<span style="color:green;">فعال</span>';}
	elseif($every_receptor_row['activate']=='0'){$every_receptor_row['activate'] = '<span style="color:red;">غیر فعال</span>';}
	
	$kharid = ($sum*100)/$every_receptor_row['discount'];
	$kharid=number_format($kharid,0,'.',',');
	
	
	##################################
	/*$terminal_id = $every_receptor_row['terminal_id'];
	$kharid_avvali = "SELECT users.mobile, users.gender, users.last_name, transaction.pan, transaction.payerId, 
						transaction.terminalId, users.id, receptors.terminal_id
							FROM transaction
							INNER JOIN receptors ON transaction.terminalId = receptors.terminal_id
							INNER JOIN users ON transaction.pan = users.cart_pri
							AND transaction.payerId = users.payerId
							OR transaction.pan = users.cart_sec
							AND transaction.payerId = users.payerId2
							OR transaction.pan = users.cart_ter
							AND transaction.payerId = users.payerId3
							WHERE receptors.terminal_id = '$terminal_id'
							GROUP BY (users.mobile)";
	$kharid_avvali_result = $mysqli->query($kharid_avvali);
	$kharid_avvali_tedad = $kharid_avvali_result->num_rows;*/
	##################################
	
	echo "
		  <tr>
					<td>$i</td>
					<td>$every_receptor_row[city]</td>
					<td>$every_receptor_row[first_name] $every_receptor_row[last_name]</td>
					<td>
						<a target='_blank' href='index.php?page=transactions_list&receptor_id_all=$every_receptor_row[id]'>
						$every_receptor_row[receptor_name]</td>
						</a>
					<td>$every_receptor_row[terminal_id]</td>
					<td>$every_receptor_row[discount]</td>
					<td>$every_receptor_row[receptor_mobile]</td>
					<td>$every_receptor_row[receptor_tel]</td>
					<td>منطقه : $every_receptor_row[receptor_zone_code] -  
						محله : $every_receptor_row[receptor_zone] - 
						$every_receptor_row[receptor_address]
						</td>
					<td>$sum_1</td>
					<td>$kharid</td>
					<td>$count</td>
					<td>$every_receptor_row[activate]</td>
		  </tr>";
	$i++;
}
?>
</tbody>
</table>
</div>