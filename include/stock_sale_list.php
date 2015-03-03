<?php if($stock_sale_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست فروش سهام</h3>
<table class="table table-striped table-hover table-bordered">
				<tr>
                	<th>ردیف</th>			
					<th>نام و نام خانوادگی</th>
                    <th>شماره موبایل</th>
					<th>تعداد سهم فروشی</th>
					<th>شماره شبا</th>
                    <th>تاریخ درخواست</th>
                    <th>کد پیگیری</th>
                    <th>مقدار سود</th>
                    <th>تاریخ واریز</th>
				</tr>
<?php
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
	include('jdf.php');
	
	$i = 1;
	$stock_list_query="SELECT * FROM stock_sale 
								INNER JOIN users 
									ON users.id = stock_sale.user_id
								;";
	$stock_list_result=$mysqli->query($stock_list_query);
	
	while($stock_list_row=$stock_list_result->fetch_assoc()){
		
		$stock_list_row['request_date'] = jdate("Y/m/d",$stock_list_row['request_date']);
		if(!empty($stock_list_row['result_date'])){$stock_list_row['result_date'] = jdate("Y/m/d",$stock_list_row['result_date']);}
		
		echo "
		  <tr>
		  			<td>$i</td>
					<td>
						<a target='_blank' title='نمایش سهام' href='index.php?page=stock_list&id=$stock_list_row[id]'><span class='glyphicon glyphicon-paperclip' style='color:red;'></span></a>
						<a href='index.php?page=transactions_list&id=$stock_list_row[id]' target='_blank'>$stock_list_row[first_name] $stock_list_row[last_name]</a>
					</td>
					<td>$stock_list_row[mobile]</td>
					<td>$stock_list_row[sale_count]</td>
					<td>$stock_list_row[sheba_number]</td>
					<td>$stock_list_row[request_date]</td>
					<td>$stock_list_row[tracking_code]</td>
					<td>$stock_list_row[amount]</td>
					<td>$stock_list_row[result_date]</td>	
		  </tr>";
		  $i++;	
	}
?> 
</table>