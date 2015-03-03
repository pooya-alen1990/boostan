<?php if($stock_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">سالنامه سهامداران</h3>
<div class="table-responsive text-center">
            <table class="table table-striped table-hover table-bordered tablesorter">
               <thead>
                <tr>
					<th>ردیف</th>
					<th>نام و نام خانوادگی</th>
                    <th>شماره موبایل</th>  
                    <th>بهار 93 (هر سهم 8000 ریال)</th>
					<th>تابستان 93 (هر سهم 8000 ریال)</th>
					<th>پاییز 93 (هر سهم 8000 ریال)</th>
                    <th>زمستان 93 (هر سهم ؟ ریال)</th>
                    <th>جمع کل سهام</th>
				</tr>
                </thead>
                <tbody>
<?php
include('jdf.php');
error_reporting(E_ALL);
ini_set('display_errors','1');
date_default_timezone_set('Asia/Tehran');

$testCounter = 0;
$maxCount = 50;

$i = 1 ;
	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");
	$gender = '';
		
############ pagination ################

/*$per_page = 300;

if(isset($_GET['pages'])){
	$pages = ($_GET['pages']-1);
	$start = $pages * $per_page;
	}else{
	$pages = 0;
	$start = $pages;	
		}

$page_count = ceil($count_users_row['COUNT(id)'] / $per_page);*/
########################################

	
	$every_body_query="SELECT * FROM stock
									INNER JOIN users
									ON stock.users_id = users.id
										 WHERE 1=1 ";
	if(isset($_GET['id'])){
	$id_passed = $_GET['id'];
	$every_body_query .= "AND stock.users_id='$id_passed' ";
	}
	
	//$every_body_query .= " LIMIT $start,$per_page ";
	
	
	$every_body_result=$mysqli->query($every_body_query);
	
	while($every_body_row=$every_body_result->fetch_assoc()){
		
		$total = $every_body_row['931_count']+$every_body_row['932_count']+$every_body_row['933_count']+$every_body_row['934_count'];
		
		if($total > $maxCount){
			$testCounter++;
			}
				
	echo "
		  <tr>
					<td>$i</td>
					<td><a href='index.php?page=transactions_list&id=$every_body_row[id]' target='_blank'>$every_body_row[first_name] $every_body_row[last_name]</a></td>
					<td>$every_body_row[mobile]</td>
					<td>
						<table class='table table-bordered table-striped table-condensed'>
							<tr class='success'>
								<td>مقدار سود</td>
								<td>".$every_body_row['931_amount']."</td>
							</tr>
							<tr class='info'>
								<td>تعداد سهام</td>
								<td>".$every_body_row['931_count']."</td>
							</tr>
							<tr  class='warning'>
								<td>باقیمانده ریالی</td>
								<td>".$every_body_row['931_remain']."</td>
							</tr>
						</table>
					</td>
					<td>
						<table class='table table-bordered table-striped table-condensed'>
							<tr class='success'>
								<td>مقدار سود</td>
								<td>".$every_body_row['932_amount']."</td>
							</tr>
							<tr class='info'>
								<td>تعداد سهام</td>
								<td>".$every_body_row['932_count']."</td>
							</tr>
							<tr  class='warning'>
								<td>باقیمانده ریالی</td>
								<td>".$every_body_row['932_remain']."</td>
							</tr>
						</table>
					</td>
					<td>
						<table class='table table-bordered table-striped table-condensed'>
							<tr class='success'>
								<td>مقدار سود</td>
								<td>".$every_body_row['933_amount']."</td>
							</tr>
							<tr class='info'>
								<td>تعداد سهام</td>
								<td>".$every_body_row['933_count']."</td>
							</tr>
							<tr  class='warning'>
								<td>باقیمانده ریالی</td>
								<td>".$every_body_row['933_remain']."</td>
							</tr>
						</table>
					</td>
					<td>
						<table class='table table-bordered table-striped table-condensed'>
							<tr class='success'>
								<td>مقدار سود</td>
								<td>".$every_body_row['934_amount']."</td>
							</tr>
							<tr class='info'>
								<td>تعداد سهام</td>
								<td>".$every_body_row['934_count']."</td>
							</tr>
							<tr  class='warning'>
								<td>باقیمانده ریالی</td>
								<td>".$every_body_row['934_remain']."</td>
							</tr>
						</table>
					</td>
					<td>$total</td>
		  </tr>";
	$i++;
}

?>
</tbody>
</table>
<?php echo $testCounter; ?>
<ul class="pagination pagination-md">
<?php
/*if(!isset($_GET['id'])){
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
}*/
?>  
</ul>
</div>