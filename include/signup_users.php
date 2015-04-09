<?php if($signup_users == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">ثبت نام مالکین</h3>
<?php 
$error ='';
$options = '';
for($i = 1300 ; $i < 1400 ;$i++){
	$options .= "<option value='$i'>$i</option>";
}

if(isset($_POST['go_register'])){
	
	$first_name = toSafeString($mysqli,$_POST['first_name']);
	$last_name = toSafeString($mysqli,$_POST['last_name']);
	$melli_code = toSafeString($mysqli,$_POST['melli_code']);
	$shenasname = toSafeString($mysqli,$_POST['shenasname']);
	$mobile = toSafeString($mysqli,$_POST['mobile']);
	$tel = toSafeString($mysqli,$_POST['tel']);
	$address = toSafeString($mysqli,$_POST['address']);
	
	$day = toSafeString($mysqli,$_POST['day']);
	$month = toSafeString($mysqli,$_POST['month']);
	$year = toSafeString($mysqli,$_POST['year']);
	
	$birthday = jmktime(0,0,0,$month,$day,$year);
	
	$personal_image = $_FILES['personal_image'];
	$karte_melli_image= $_FILES['karte_melli_image'];
	
	if(
		!empty($first_name)&&
		!empty($last_name)&&
		!empty($melli_code)&&
		!empty($shenasname)&&
		//!empty($mobile)&&
		!empty($tel)
	){
		
		//check new melli_code
		$check_melli_code_query="SELECT id,melli_code FROM users WHERE melli_code='$melli_code'";
		$check_melli_code_result=$mysqli->query($check_melli_code_query);
		$check_melli_code_rows=$check_melli_code_result->num_rows;
		$check_melli_code_result->close();
				
		//insert record to receptors table		
		if($check_melli_code_rows==0){
			
			if(isset($_FILES['personal_image']['name'])){
				if($personal_image['error'] == "0"){
					$personal_image['name'] = time().'.jpg';
					$address_personal_image = "images/users/personal/$personal_image[name]";
					move_uploaded_file($personal_image['tmp_name'],$address_personal_image);
				}
			}
			if(isset($_FILES['karte_melli_image'])){
				if($karte_melli_image['error'] == "0"){
					$karte_melli_image['name'] = time().'.jpg';
					$address_melli_image = "images/users/melli_card/$karte_melli_image[name]";
					move_uploaded_file($karte_melli_image['tmp_name'],$address_melli_image);
				}
			}
					$signup_users_query="INSERT INTO `users`(`id`, `first_name`, `last_name`, `melli_code`, `shenasname`, `mobile`, `tel`, `address`, `birthday`, `personal_image`, `karte_melli_image`) VALUES ('','$first_name','$last_name','$melli_code','$shenasname','$mobile','$tel','$address','$birthday','$personal_image[name]','$karte_melli_image[name]')";
					$signup_users_result = $mysqli->query($signup_users_query);
					//echo $signup_users_query;
					
					
					
				if($signup_users_result){
					
					
				//sleep(3);
				header("Location: index.php?page=add_contract&user_melli_code=$melli_code");
					
				$error = "		<div class='col-sm-12'>
												<div class='alert alert-success alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
												  ثبت نام با موفقیت انجام شد.
												</div>
											</div>
										";
										
										
				}
				else{
					$error = "
											<div class='col-sm-12'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													خطا در ثبت،لطفا بعدا تلاش کنید.
												</div>
											</div>
										";
				}
			}	
		else{
			$error = "
											<div class='col-sm-12'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													کد ملی قبلا ثبت شده است. لطفا دوباره تلاش کنید.
												</div>
											</div>
										";
		}//close check new username
		
		
	}
	else{
		$error = "
											<div class='col-sm-12'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													لطفا فیلدهای ستاره دار را پر نمایید.
												</div>
											</div>
										";
	}
}
?>
<?php echo $error;?>
  <form method="post" role="form" class="form-horizontal col-sm-10 col-xs-10 col-md-7 pull-right" enctype="multipart/form-data" dir="rtl">
  <div class="form-group">
            
           <div class="col-sm-8"><input id="first_name" class="form-control" type="text" name="first_name" tabindex="1" autofocus></div>
           <label class="control-label col-sm-4" for="first_name">نام : </label>
 </div>   
 <div class="form-group">        
            
            <div class="col-sm-8"><input class="form-control" type="text" name="last_name" tabindex="2"></div>
            <label class="control-label col-sm-4" for="last_name">نام خانوادگی : </label>
 </div>
 <div class="form-group">           
            
            <div class="col-sm-8"><input class="form-control numeric" type="text" name="melli_code" maxlength="10" tabindex="3"></div>
            <label class=" control-label col-sm-4" for="melli_code">کد ملی : </label>
  </div>
  <div class="form-group">           
            
            <div class="col-sm-8"><input class="form-control numeric" type="text" name="shenasname" maxlength="10" tabindex="3"></div>
            <label class=" control-label col-sm-4" for="shenasname">شماره شناسنامه : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-sm-8"><input type="text" maxlength="11" class="form-control" name="mobile" tabindex="4"></div>
            <label class=" control-label col-sm-4" for="mobile">موبایل : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-sm-8"><input class="form-control"  maxlength="12" type="text" name="tel" tabindex="5"></div>
            <label class=" control-label col-sm-4" for="tel">تلفن : </label>
  </div>
  <div class="form-group">          
            
            
            <div class="col-sm-8"><textarea class="form-control" tabindex="6"  name="address"></textarea></div>
            <label class="control-label col-sm-4" for="address">آدرس : </label>
   </div>            
            
   <div class="form-group">          
            <div class="col-sm-8">

            <select  style="display: inline-block;width: auto;" id="form_birthday_day" name="day" required class="form-control"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
            
            
         <select style="display: inline-block;width: auto;" id="form_birthday_month" name="month" required class="form-control">
            <option value="1">فروردین</option>
            <option value="2">اردیبهشت</option>
            <option value="3">خرداد</option>
            <option value="4">تیر</option>
            <option value="5">مرداد</option>
            <option value="6">شهریور</option>
            <option value="7">مهر</option>
            <option value="8">آبان</option>
            <option value="9">آذر</option>
            <option value="10">دی</option>
            <option value="11">بهمن</option>
            <option value="12">اسفند</option>
        </select>
            
            
            <select  style="display: inline-block;width: auto;" id="form_birthday_year" name="year" required class="form-control">
            <?php echo $options; ?>
            </select>
         </div>
         <label class=" control-label col-sm-4" for="birthday">تاریخ تولد : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-sm-8"><input class="" type="file" name="personal_image" tabindex="8"></div>
            <label class=" control-label col-sm-4" for="personal_image">عکس پرسنلی</label>
  </div>
  <div class="form-group">          
            
            <div class="col-sm-8"><input class="" type="file" name="karte_melli_image" tabindex="9"></div>
            <label class=" control-label col-sm-4" for="karte_melli_image">تصویر کارت ملی</label>
  </div>
      
      <div class="col-sm-6">
            <input type="reset" value="ویرایش" class=" btn btn-warning" tabindex="11">
            <input type="submit" name="go_register" class=" btn btn-primary" value="ثبت نام" tabindex="10">
       </div>
            
          
    </form>
    