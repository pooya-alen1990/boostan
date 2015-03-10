<?php if($add_contract == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">اضافه کردن قرارداد</h3>
<?php 
$error ='';
$options = '';
for($i = 1300 ; $i < 1400 ;$i++){
	$options .= "<option value='$i'>$i</option>";
}

if(isset($_POST['go_register'])){
	
	$melli_code = toSafeString($mysqli,$_POST['melli_code']);
	$pelak_sabti = toSafeString($mysqli,$_POST['pelak_sabti']);
	$percent = toSafeString($mysqli,$_POST['percent']);
	$duration = toSafeString($mysqli,$_POST['duration']);
	$gholname_image = $_FILES['gholname_image'];
	$check_percent = false;
	
	$day = toSafeString($mysqli,$_POST['day']);
	$month = toSafeString($mysqli,$_POST['month']);
	$year = toSafeString($mysqli,$_POST['year']);
	
	$begin_date = jmktime(0,0,0,$month,$day,$year);
	
	
	if(
		!empty($melli_code)&&
		!empty($pelak_sabti)&&
		!empty($percent)
	){
		
		
		//check exist melli_code
		$check_melli_code_query="SELECT id,melli_code FROM users WHERE melli_code='$melli_code'";
		$check_melli_code_result=$mysqli->query($check_melli_code_query);
		$check_melli_code_rows=$check_melli_code_result->num_rows;
		$check_melli_code_row=$check_melli_code_result->fetch_assoc();
		$check_melli_code_result->close();
		
		//check exist pelak_sabti
		$check_pelak_sabti_query="SELECT id,pelak_sabti FROM vahed WHERE pelak_sabti='$pelak_sabti'";
		$check_pelak_sabti_result=$mysqli->query($check_pelak_sabti_query);
		$check_pelak_sabti_rows=$check_pelak_sabti_result->num_rows;
		$check_pelak_sabti_row=$check_pelak_sabti_result->fetch_assoc();
		$check_pelak_sabti_result->close();
		
		//check check percent
		$check_percent_query="SELECT * FROM contract WHERE vahed_id='$check_pelak_sabti_row[id]'";
		$check_percent_result=$mysqli->query($check_percent_query);
		$sum_percent = 0;
		while($check_percent_row=$check_percent_result->fetch_assoc()){
			$sum_percent += $check_percent_row['percent'];
			}
		$sum_percent +=  $percent;
		if($sum_percent <= 100){
			$check_percent = true;
			}
		$check_percent_result->close();
				
	
		if($check_melli_code_rows==1){
			if($percent > 0 && $percent <=100 && $check_percent == true){
			if($check_pelak_sabti_rows==1){
			if(isset($_FILES['gholname_image']['name'])){
				if($gholname_image['error'] == "0"){
					$gholname_image['name'] = time().'.jpg';
					$address_gholname_image = "images/gholname/$gholname_image[name]";
					move_uploaded_file($gholname_image['tmp_name'],$address_gholname_image);
				}
			}
			
			$signup_contract_query="INSERT INTO `contract`(`id`, `vahed_id`, `users_id`, `percent`, `gholname_image`, `begin_date`, `duration`) VALUES 
												('','$check_pelak_sabti_row[id]','$check_melli_code_row[id]','$percent','$gholname_image[name]','$begin_date','$duration')";
			$signup_contract_result = $mysqli->query($signup_contract_query);
						
			if($signup_contract_result){
				$error = CONTRACT_SUCCESSFUL;					
			}else{
				$error = CONTRACT_FAILED;
			}
		}else{
			$error = CONTRACT_PELAK_SABTI;
			}
			}else{
			$error = CONTRACT_PERCENT;	
				}
			}else{
			$error = CONTRACT_MELLI_CODE;
		}
	}else{
		$error = CONTRACT_SETAREDAR;
	}
}
?>
<?php echo $error;?>
<form method="post" role="form" class="form-horizontal col-sm-10 col-xs-10 col-md-7 pull-right" enctype="multipart/form-data" dir="rtl">

 <div class="form-group">           
            
            <div class="col-sm-8"><input class="form-control numeric" type="text" name="melli_code" maxlength="10" tabindex="1"></div>
            <label class=" control-label col-sm-4" for="melli_code">کد ملی مالک : </label>
  </div>
  
  <div class="form-group">          
            
            <div class="col-sm-8"><input type="text" maxlength="4" class="form-control" name="pelak_sabti" tabindex="2"></div>
            <label class=" control-label col-sm-4" for="pelak_sabti">پلاک ثبتی واحد : </label>
  </div>
  
  <div class="form-group">          
            
            <div class="col-sm-8"><input type="text" maxlength="3" class="form-control" name="percent" tabindex="3"></div>
            <label class=" control-label col-sm-4" for="percent">درصد مالکیت : </label>
  </div>           

  <div class="form-group">          
            
            <div class="col-sm-8"><input type="file" name="gholname_image" tabindex="4"></div>
            <label class=" control-label col-sm-4" for="gholname_image">تصویر قولنامه</label>
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
         <label class=" control-label col-sm-4" for="begin_date">تاریخ عقد قرارداد : </label>
  </div>
  
      <div class="form-group">          
            
            <div class="col-sm-8"><input type="text" maxlength="2" class="form-control" name="duration" tabindex="3"></div>
            <label class=" control-label col-sm-4" for="duration">مدت قرارداد (ماه) : </label>
  </div>  
      
      <div class="col-sm-6">
            <input type="reset" value="ویرایش" class=" btn btn-warning" tabindex="6">
            <input type="submit" name="go_register" class=" btn btn-primary" value="ثبت قرارداد" tabindex="5">
       </div>
     
</form>
    