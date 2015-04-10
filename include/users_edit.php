<?php if($users_edit == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">ویرایش مالکین</h3>

<?php 
if(isset($_GET['user_melli_code'])){
	$_POST['user_find'] = true;
	$_POST['melli_code'] = $_GET['user_melli_code'];
	}
	
if(!isset($_POST['user_find'])){
	echo '<form method="post" role="form" class="form-inline">
			<label for="melli_code"> کد ملی : </label>
			<input type="text" name="melli_code" class="form-control" required>
			<input type="submit" name="user_find" value="جستجو"  class="form-control btn btn-md btn-primary">
		</form>';
}
?>
<?php

$error = '';

if(isset($_POST['go_update'])){
					
	$first_name = toSafeString($mysqli,$_POST['first_name']);
	$last_name = toSafeString($mysqli,$_POST['last_name']);
	$shenasname = toSafeString($mysqli,$_POST['shenasname']);
	$melli_code = toSafeString($mysqli,$_POST['melli_code']);
	$mobile = toSafeString($mysqli,$_POST['mobile']);
	$tel = toSafeString($mysqli,$_POST['tel']);
	$address = toSafeString($mysqli,$_POST['address']);
	
	$personal_image = $_FILES['personal_image'];
	$karte_melli_image= $_FILES['karte_melli_image'];
	
	if(isset($_FILES['personal_image']['name'])){
				if($personal_image['error'] == "0"){
					$personal_image['name'] = time().'.jpg';
					$address_personal_image = "images/users/personal/$personal_image[name]";
					move_uploaded_file($personal_image['tmp_name'],$address_personal_image);
					
					$personal_query = "UPDATE users SET `personal_image`= '$personal_image[name]' WHERE melli_code='$melli_code' ; ";			 					$mysqli->query($personal_query);
				}
			}
			if(isset($_FILES['karte_melli_image'])){
				if($karte_melli_image['error'] == "0"){
					$karte_melli_image['name'] = time().'.jpg';
					$address_melli_image = "images/users/melli_card/$karte_melli_image[name]";
					move_uploaded_file($karte_melli_image['tmp_name'],$address_melli_image);
					
					$karte_melli_query = "UPDATE users SET `karte_melli_image` = '$karte_melli_image[name]'
							 						WHERE melli_code='$melli_code' ; ";	
					$mysqli->query($karte_melli_query);
				}
			}
			
	
	if(true){
				$update_profile_query = "UPDATE users SET 
						first_name='$first_name',last_name='$last_name',shenasname='$shenasname'
							,mobile='$mobile',tel='$tel',address='$address'
								 WHERE melli_code='$melli_code' ; ";
								 
				$update_profile_result=$mysqli->query($update_profile_query); 
				if($update_profile_result){
					
					$error = USERS_EDIT_SUCCESSFUL;
					
					}else{
						$error = CONTRACT_SETAREDAR;
						}
}
else{
	$error = CONTRACT_FAILED;
	}
}

###################################################
	
if(isset($_POST['user_find'])){
	
	$melli_code = $_POST['melli_code'];
	$update_profile_query = "SELECT * FROM users WHERE melli_code='$melli_code';";
	$update_profile_result = $mysqli->query($update_profile_query);
	$update_profile_row = $update_profile_result->fetch_assoc();
	
}

?>
<?php echo $error; if(!isset($_POST['user_find'])) die();
		if(empty($update_profile_row['id'])){ die('موردی یافت نشد. <a href="index.php?page=users_edit">بازگشت</a>');}
?>
<div class="row">
    <div class="col-lg-12">

        	  <form method="post" role="form" class="form-horizontal col-sm-10 col-xs-10 col-md-7 pull-right" enctype="multipart/form-data" dir="rtl">
  <div class="form-group">
            
           <div class="col-sm-8"><input id="first_name" class="form-control" type="text" value="<?php echo $update_profile_row['first_name'] ;?>" name="first_name" tabindex="1" autofocus></div>
           <label class="control-label col-sm-4" for="first_name">نام : </label>
 </div>   
 <div class="form-group">        
            
            <div class="col-sm-8"><input class="form-control" value="<?php echo $update_profile_row['last_name'] ;?>" type="text" name="last_name" tabindex="2"></div>
            <label class="control-label col-sm-4" for="last_name">نام خانوادگی : </label>
 </div>
 <div class="form-group">           
            
            <div class="col-sm-8"><input class="form-control numeric"  value="<?php echo $update_profile_row['melli_code'] ;?>" disabled type="text" name="melli_code" maxlength="10" tabindex="3"></div>
            <label class=" control-label col-sm-4" for="melli_code">کد ملی : </label>
  </div>
  <div class="form-group">           
            
            <div class="col-sm-8"><input class="form-control numeric" type="text"  value="<?php echo $update_profile_row['shenasname'] ;?>" name="shenasname" maxlength="10" tabindex="3"></div>
            <label class=" control-label col-sm-4" for="shenasname">شماره شناسنامه : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-sm-8"><input type="text"  maxlength="11" value="<?php echo $update_profile_row['mobile'] ;?>" class="form-control" name="mobile" tabindex="4"></div>
            <label class=" control-label col-sm-4" for="mobile">موبایل : </label>
  </div>
  <div class="form-group">          
            
            <div class="col-sm-8"><input class="form-control"  value="<?php echo $update_profile_row['tel'] ;?>" maxlength="12" type="text" name="tel" tabindex="5"></div>
            <label class=" control-label col-sm-4" for="tel">تلفن : </label>
  </div>
  <div class="form-group">          
            
            
            <div class="col-sm-8"><textarea class="form-control" tabindex="6"  name="address"><?php echo $update_profile_row['address'] ;?></textarea></div>
            <label class="control-label col-sm-4" for="address">آدرس : </label>
   </div>            

  <div class="form-group">          
           <?php if($update_profile_row['karte_melli_image']){
				$update_profile_row['karte_melli_image'] = '<a target="_blank" href="images/users/melli_card/'.$update_profile_row['karte_melli_image'].'"><img src="images/users/melli_card/'.$update_profile_row['karte_melli_image'].'" width="30"></a>';
				}else{
				$update_profile_row['karte_melli_image'] = '<span style="color:red">ندارد</span>';	
					}
			
			if($update_profile_row['personal_image']){
				$update_profile_row['personal_image'] = '<a target="_blank" href="images/users/personal/'.$update_profile_row['personal_image'].'"><img src="images/users/personal/'.$update_profile_row['personal_image'].'" width="30"></a>';
				}else{
				$update_profile_row['personal_image'] = '<span style="color:red">ندارد</span>';	
					}
					
			echo 'تصویر کارت ملی : '.$update_profile_row['karte_melli_image'].'<br>';
			echo 'عکس پرسنلی : '.$update_profile_row['personal_image'];
		?>
        <div class="form-group">  
        <div class="col-sm-8"><input class="" type="file" name="personal_image" tabindex="8"></div>
            <label class=" control-label col-sm-4" for="personal_image">عکس پرسنلی</label>
         </div>
         
       <div class="form-group">  
        <div class="col-sm-8"><input class="" type="file" name="karte_melli_image" tabindex="9"></div>
            <label class=" control-label col-sm-4" for="karte_melli_image">تصویر کارت ملی</label>
        </div>    
  </div>
      <input value="<?php echo $update_profile_row['melli_code'] ;?>"  type="hidden" name="melli_code">
      <div class="col-sm-6">
            <input type="submit" name="go_update" class=" btn btn-primary" value="ویرایش" tabindex="10">
       </div>
            
          
    </form>
        
    </div>
</div>
