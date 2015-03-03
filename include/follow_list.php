<?php if($follow_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست پیگیری</h3>
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
	
	$count_users="SELECT COUNT(id) FROM follow;";
	$count_users_result=$mysqli->query($count_users);
	$count_users_row=$count_users_result->fetch_assoc();
		
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
	
	############## INSERT QUERY #################################
	$error = '';
	if(isset($_POST['add_follow'])){
		
		$poll = 0;
		@$poll = $_POST['poll_1']; 
		@$poll .= $_POST['poll_2'];
		@$poll .= $_POST['poll_3']; 
		@$poll .= $_POST['poll_4'];
		@$poll .= $_POST['poll_5'];
		@$poll .= $_POST['poll_6'];
		@$poll .= $_POST['poll_7'];
		@$poll .= $_POST['poll_8'];
		@$poll .= $_POST['poll_9'];
		
		
		$admin_id = $_POST['admin_id'];
		if(!empty($_POST['explain_cat'])){$explain = $_POST['explain_cat'].'<br>'.$_POST['explain'];}else{$explain = $_POST['explain'];}
		$follow_date = time();
		$user_id = $_GET['user_id'];
		
			$add_follow_query = "INSERT INTO `follow` (`id`,`user_id`,`explain`,`poll`,`follow_date`,`admin_id`)
										VALUES ('','$user_id','$explain','$poll','$follow_date','$admin_id') ; ";
							
				$add_follow_result = $mysqli->query($add_follow_query);
				
				if($add_follow_result){
					
				$error = "		<div class='col-xs-8'>
												<div class='alert alert-success alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													پیگیری با موفقیت ثبت شد
												</div>
											</div>
										";
				}else{
					
				$error = "
											<div class='col-xs-8'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													خطا در ثبت،لطفا بعدا تلاش کنید.
												</div>
											</div>
										";
				}
		
		}
	######################################################
	
	$i = 1;
	$follow_list_query="SELECT users.marketers_id,users.first_name,users.last_name,users.mobile,users.id AS usersId,
									follow.id,follow.user_id,follow.admin_id,follow.explain,follow.poll,follow.follow_date,
										admins.id,admins.first_name AS admin_first_name,admins.last_name AS admin_last_name FROM follow 
								INNER JOIN users 
									ON users.id = follow.user_id
								INNER JOIN admins
									ON admins.id = follow.admin_id
								";
								
			if(isset($_GET['user_id'])){$follow_list_query .= " WHERE users.id = $_GET[user_id]";}
								
			$follow_list_query .= " ORDER BY follow.follow_date ASC  ";
			
			$follow_list_query .= " LIMIT $start,$per_page ; ";
								
	$follow_list_result=$mysqli->query($follow_list_query);
	$rows = $follow_list_result->num_rows;
	if($rows != '0'){
	echo "<table class='table table-striped table-hover table-bordered'>
				<tr>
                	<th>ردیف</th>			
					<th>نام و نام خانوادگی</th>
                    <th>شماره موبایل</th>
					<th>کد بازاریاب</th>
					<th>نام پیگیری کننده</th>
                    <th>تاریخ پیگیری</th>
                    <th>توضیحات</th>
					<th>نتیجه نظرسنجی</th>
				</tr>";
	
	while($follow_list_row=$follow_list_result->fetch_assoc()){
		
		$follow_list_row['follow_date'] = jdate("H:i:s - Y/m/d",$follow_list_row['follow_date']);
		
		
			$count_follow_query = "SELECT COUNT(id) FROM follow WHERE user_id='$follow_list_row[usersId]' ;";
			$count_follow_result = $mysqli->query($count_follow_query);
			$count_follow_row = $count_follow_result->fetch_assoc();
		
	$rejection = "عدم پاسخگویی.<br>";
	$color = "green";
	if(strpos($follow_list_row['explain'],$rejection) !== false){
		$color = "red";
		}
		
		echo "
		  <tr>
		  			<td>$i</td>
					<td>
						<a target='_blank' title='ویرایش اطلاعات' href='index.php?page=users_edit&user_mobile=$follow_list_row[mobile]'><span class='glyphicon glyphicon-pencil' style='color:blue;'></span></a>
						<a target='_blank' title='نمایش سهام' href='index.php?page=stock_list&id=$follow_list_row[usersId]'><span class='glyphicon glyphicon-paperclip' style='color:red;'></span></a>
						<a href='index.php?page=transactions_list&id=$follow_list_row[usersId]' target='_blank'>$follow_list_row[first_name] $follow_list_row[last_name]</a><br>
						<a target='_blank' title='نمایش پیگیری' href='index.php?page=follow_list&user_id=$follow_list_row[usersId]'><span class='glyphicon glyphicon-phone-alt' style='color:".$color.";'></span> پیگیری <span class='badge'>".$count_follow_row['COUNT(id)']."</span></a>
					</td>
					<td>$follow_list_row[mobile]</td>
					<td>$follow_list_row[marketers_id]</td>
					<td>$follow_list_row[admin_first_name] $follow_list_row[admin_last_name]</td>
					<td>$follow_list_row[follow_date]</td>
					<td>$follow_list_row[explain]</td>	
					<td>$follow_list_row[poll]</td>
		  </tr>";
		  $i++;	
	}
	}else{
		echo 'هنوز هیچ رکورد پیگیری ثبت نشده است!';
		}
?>
</table>
<hr>
<?php
	
	
	if(!isset($_GET['user_id'])){

		echo '<ul class="pagination pagination-md">';
		
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
					
				  echo "<li><a href='index.php?page=follow_list&pages=1'>اولین</a></li>";	
				  echo "<li><a href='index.php?page=follow_list&pages=$prev'>قبلی &raquo;</a></li>";
				  for($i=1;$i<=$page_count;$i++){
					  if($i == $_GET['pages']){$activepage = 'active';}else{$activepage = ' ';}
					echo "<li class='$activepage'><a href='index.php?page=follow_list&pages=$i'>$i</a></li>";
				  }
				  echo "<li><a href='index.php?page=follow_list&pages=$next'>&laquo; بعدی</a></li>";
				  echo "<li><a href='index.php?page=follow_list&pages=".$page_count."'>آخرین</a></li>";
		}
		 
		echo '</ul>';
		
		die();}
	
	$user_query="SELECT * FROM users WHERE id = '$_GET[user_id]' ; ";
	$user_result=$mysqli->query($user_query);
	$user_row=$user_result->fetch_assoc();
	
	$full_name = $user_row['first_name'].' '.$user_row['last_name'];
?> 


<div class="col-lg-5 col-md-5 pull-right">
<?php echo "<h5>ثبت پیگیری جدید برای $full_name : </h5>"; ?>
    <form method="post" role="form" class="form">
    	<select class="form-control" name="explain_cat">
        	<option value="">---سایر---</option>
            <option>توضیحات تکمیلی ارائه شد، سوالی نبود.</option>
            <option>طرح کاملا توضیح داده شد ، توجیه شدند.</option>
            <option>اعلام انصراف.</option>
            <option>عدم پاسخگویی.</option>
        </select><br>
        <textarea name="explain" class="form-control" rows="3" style="height:97px;"></textarea><br>
        <input type="hidden" name="admin_id" value="<?php echo $_SESSION['MM_admin_id']; ?>">

</div>

<div class="col-lg-6 col-md-6 pull-left">
<?php echo "<h5>علت عدم خرید $full_name از سانی کدام است؟</h5>"; ?>

    	
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_1" value="1"> 1- عدم وجود فروشگاه های سانی در اطراف محل سکونت ما
            </label>
        </div>
        <div class="clearfix"></div>
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_2" value="2"> 2- عدم اعتماد به طرح سانی
            </label>
        </div>
        <div class="clearfix"></div>
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_3" value="3"> 3- عدم اطلاع کافی از طرح
            </label>
        </div>
        <div class="clearfix"></div>
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_4" value="4"> 4- کم بودن درصد سرمایه گذاری
            </label>
        </div>
        <div class="clearfix"></div>
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_5" value="5"> 5- نداشتن تبلیغ مناسب برای طرح سانی
            </label>
        </div>
  		<div class="clearfix"></div>
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_6" value="6"> 6- فراموش کردن طرح سانی
            </label>
        </div>
  		<div class="clearfix"></div>
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_7" value="7"> 7- خرید کارتی ندارند
            </label>
        </div>
  		<div class="clearfix"></div>
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_8" value="8"> 8- عدم همکاری فروشنده
            </label>
        </div>
        <div class="clearfix"></div>
        <div class="checkbox pull-right">
            <label>
           		<input type="checkbox" name="poll_9" value="9"> 9- سایر
            </label>
        </div>
  		<div class="clearfix"></div>
        <input type="submit" name="add_follow" value="ثبت پیگیری" class="form-control btn btn-md btn-success">
    </form>
</div>
