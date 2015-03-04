<?php if($signup_users == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">ثبت نام مالکین</h3>
<?php 
$error ='';

#### FUNCTIONS ########
	function toSafeString($mysqli,$string){
			$string=$mysqli->real_escape_string($string);
			$string=htmlentities($string,ENT_QUOTES,"utf-8");
			$string=trim($string);
			return $string;
		}

if(isset($_POST['go_register'])){
	$first_name=toSafeString($mysqli,$_POST['first_name']);
	$last_name=toSafeString($mysqli,$_POST['last_name']);
	$melli_code=toSafeString($mysqli,$_POST['melli_code']);
	$category=toSafeString($mysqli,$_POST['category']);
	$sub_category=toSafeString($mysqli,$_POST['sub_category']);
	$terminal_id=toSafeString($mysqli,$_POST['terminal_id']);
	$discount=toSafeString($mysqli,$_POST['discount']);
	$city=toSafeString($mysqli,$_POST['city']);
	$receptor_name=toSafeString($mysqli,$_POST['receptor_name']);
	$receptor_zone_code=toSafeString($mysqli,$_POST['receptor_zone_code']);
	$receptor_zone=toSafeString($mysqli,$_POST['receptor_zone']);
	/*$receptor_street=toSafeString($mysqli,$_POST['receptor_street']);
	$receptor_alley=toSafeString($mysqli,$_POST['receptor_alley']);
	$receptor_plaque=toSafeString($mysqli,$_POST['receptor_plaque']);*/
	$receptor_address=toSafeString($mysqli,$_POST['receptor_address']);
	$receptor_tel=toSafeString($mysqli,$_POST['receptor_tel']);
	$receptor_mobile=toSafeString($mysqli,$_POST['receptor_mobile']);
	
	if(
	!empty($first_name)&&
	!empty($last_name)&&
	!empty($melli_code)&&
	!empty($category)&&
	!empty($sub_category)&&
	!empty($discount)&&
	!empty($receptor_tel)
	){
		
		//check new melli_code
		$check_melli_code_query="SELECT id,melli_code FROM receptors WHERE melli_code='$melli_code'";
		$check_melli_code_result=$mysqli->query($check_melli_code_query);
		$check_melli_code_rows=$check_melli_code_result->num_rows;
		$check_melli_code_result->close();
		
		//check new cart_number
/*		$check_pos_number_query="SELECT id,pos_number FROM receptors WHERE pos_number='$pos_number'";
		$check_pos_number_result=$mysqli->query($check_pos_number_query);
		$check_pos_number_rows=$check_pos_number_result->num_rows;
		$check_pos_number_result->close();*/
			
		//insert record to receptors table		
		if(/*$check_pos_number_rows==0 &&*/ $check_melli_code_rows==0){

					$signup_user_query="INSERT INTO receptors (id,first_name,last_name,melli_code,category,sub_category,terminal_id,discount,city,receptor_name,receptor_zone_code,receptor_zone,receptor_address,receptor_tel,receptor_mobile,register_date,marketers_id,activate)
					VALUES ('','$first_name','$last_name','$melli_code','$category','$sub_category','$terminal_id','$discount','$city','$receptor_name','$receptor_zone_code','$receptor_zone','$receptor_address','$receptor_tel','$receptor_mobile',NOW(),'','1');";
					$register_result=$mysqli->query($signup_user_query);
				if($register_result){
				$error = "		<div class='col-xs-8'>
												<div class='alert alert-success alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													پذیرنده ثبت شد.
												</div>
											</div>
										";
				}
				else{
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
		else{
			$error = "
											<div class='col-xs-8'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													کد ملی یا شماره POS قبلا ثبت شده است. لطفا دوباره تلاش کنید.
												</div>
											</div>
										";
		}//close check new username
		
		
	}
	else{
		$error = "
											<div class='col-xs-8'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													لطفا فیلدهای ستاره دار را پر نمایید.
												</div>
											</div>
										";
	}
}
?>

  <form method="post" role="form" class="form-horizontal col-xs-4 pull-right" dir="rtl">
  <div class="form-group">
            
           <div class="col-xs-8"><input id="first_name" value="<?php if(isset($first_name)) echo $first_name; ?>" class="form-control" type="text" name="first_name" tabindex="1" autofocus></div>
           <label class="control-label col-sm-4" for="first_name">نام : </label>
 </div>   
 <div class="form-group">        
            
            <div class="col-xs-8"><input value="<?php if(isset($last_name)) echo $last_name; ?>" class="form-control" type="text" name="last_name" tabindex="2"></div>
            <label class="control-label col-sm-4" for="last_name">نام خانوادگی : </label>
 </div>
 <div class="form-group">           
            
            <div class="col-xs-8"><input value="<?php if(isset($melli_code)) echo $melli_code; ?>" class="form-control numeric" type="text" name="melli_code" maxlength="10" tabindex="3"></div>
            <label class=" control-label col-sm-4" for="melli_code">کد ملی : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-xs-8"><input value="<?php if(isset($category)) echo $category; ?>" type="text" class="form-control" name="category" tabindex="4"></div>
            <label class=" control-label col-sm-4" for="category">صنف : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-xs-8"><input value="<?php if(isset($sub_category)) echo $sub_category; ?>" class="form-control" type="text" name="sub_category" tabindex="5"></div>
            <label class=" control-label col-sm-4" for="sub_category">زیر صنف : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-xs-8"><input value="<?php if(isset($pos_number)) echo $pos_number; ?>" class="form-control" type="text" name="terminal_id" tabindex="6"></div>
            <label class="control-label col-sm-4" for="terminal_id">شماره پایانه : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-xs-8"><input value="<?php if(isset($discount)) echo $discount; ?>" type="text" class="form-control numeric" name="discount" tabindex="7"></div>
            <label class=" control-label col-sm-4" for="discount">درصد تخفیف : </label>
 </div>
 <div class="form-group">          
            
            <div class="col-xs-8"><select class="form-control" name="city" tabindex="9">
            			<option>تهران</option>
                        <option>تبریز</option>
                        </select></div>
                        <label class="control-label col-sm-4" for="city">شهر : </label>
  </div>
 <div class="form-group">
   
            <div class="col-xs-8"><input class="form-control" type="text" name="receptor_name" tabindex="9"></div>
            <label class="control-label col-sm-4" for="receptor_name">نام پذیرنده : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-xs-8"><select class="form-control" name="receptor_zone_code" tabindex="9">
            			<option value="1">1</option><option value="2">2</option>
                        <option value="3">3</option><option value="4">4</option>
                        <option value="5">5</option><option value="6">6</option>
                        <option value="7">7</option><option value="8">8</option>
                        <option value="9">9</option><option value="10">10</option>
                        <option value="11">11</option><option value="12">12</option>
                        <option value="13">13</option><option value="14">14</option>
                        <option value="15">15</option><option value="16">16</option>
                        <option value="17">17</option><option value="18">18</option>
                        <option value="19">19</option><option value="20">20</option>
                        <option value="21">21</option><option value="22">22</option></select></div>
                        <label class="control-label col-sm-4" for="receptor_zone_code">منطقه شهرداری : </label>
  </div>
  <div class="form-group">         
            
            <div class="col-xs-8"><input value="<?php if(isset($receptor_zone)) echo $receptor_zone; ?>" type="text" class="form-control" name="receptor_zone" tabindex="10"></div>
            <label class="control-label col-sm-4" for="receptor_zone">نام محله : </label>
  </div>
  <div class="form-group">          
            
            
            <div class="col-xs-8"><textarea class="form-control"  name="receptor_address"><?php if(isset($receptor_address)) echo $receptor_address; ?></textarea></div>
            <label class="control-label col-sm-4" for="receptor_address">آدرس : </label>
            <!--
            <label class="" for="receptor_street">خیابان : </label><div class="col-xs-8"><input value="" type="text" name="receptor_street" tabindex="11">
            <label class="" for="receptor_alley">کوچه : </label><div class="col-xs-8"><input value="" type="text" name="receptor_alley" tabindex="12">
            <label class="" for="receptor_plaque">پلاک : </label><div class="col-xs-8"><input value="" type="text" name="receptor_plaque" class="numeric" tabindex="13">
            -->
   </div>
   <div class="form-group">         
            
            <div class="col-xs-8"><input class="form-control" value="<?php if(isset($receptor_tel)) echo $receptor_tel; ?>" type="text" name="receptor_tel" tabindex="14"></div>
            <label class="control-label col-sm-4" for="receptor_tel">تلفن ثابت : </label>
   </div>
   <div class="form-group">         
                  
            <div class="col-xs-8"><input class="form-control numeric" value="<?php if(isset($receptor_mobile)) echo $receptor_mobile; ?>" type="text" name="receptor_mobile" tabindex="15" maxlength="11"></div>
            <label class="control-label col-sm-4" for="receptor_mobile">تلفن همراه : </label>       
    </div>
      
            <input type="reset" value="ویرایش" class="form-control btn btn-warning" tabindex="16"><br><br>
       
            <input type="submit" name="go_register" class="form-control btn btn-primary" value="ثبت نام" tabindex="17">
          
    </form>
    <?php echo $error; 
	?>