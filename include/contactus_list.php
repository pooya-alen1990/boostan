<?php if($contactus_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">گزارش ارتباط با ما</h3>
<table class="table table-striped table-hover table-bordered">
				<tr>					
					<th width="10%">نام و نام خانوادگی</th>
                    <th width="10%">شماره موبایل</th>
					<th width="5%">نوع درخواست</th>
					<th width="10%">عنوان پیام</th>
                    <th width="5%">تاریخ ثبت</th>
                    <th width="30%">متن پیام</th>
                    <th width="30%">پیگیری</th>
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
	
	### UPDATE QUERY ###
	if(isset($_POST['id'])){
		
		$id = $_POST['id'];
		$follow = $_POST['follow'];
		
		$update_query="UPDATE `contactus` SET `follow`='$follow' WHERE id='$id' ; ";
		$update_result=$mysqli->query($update_query);
	}
	####################
	
	$contactus_query="SELECT * FROM contactus;";
	$contactus_result=$mysqli->query($contactus_query);
	
	
	while($contactus_row=$contactus_result->fetch_assoc()){
		
		$register_date = substr($contactus_row['request_date'],0,10);
		$timestamp = strtotime($register_date);
		$register_date = jdate("Y/m/d",$timestamp);
		
		echo "
		  <tr>
					<td>$contactus_row[first_name] $contactus_row[last_name]</td>
					<td>$contactus_row[mobile]</td>
					<td>$contactus_row[category]</td>
					<td>$contactus_row[title]</td>
					<td>$register_date</td>
					<td>$contactus_row[message]</td>
					<td>
					<form method='post'>
						<input type='hidden' name='id' value='$contactus_row[id]'>
						<textarea style='resize:none;' onBlur='form.submit()' name='follow' class='form-control'>$contactus_row[follow]</textarea>
					</form>
					</td>	
		  </tr>";	
	}
?> 
</table>