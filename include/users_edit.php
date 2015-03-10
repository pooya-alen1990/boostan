<?php if($users_edit == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">ویرایش مالکین</h3>

<?php 
if(isset($_GET['user_mobile'])){
	$_POST['user_find'] = true;
	$_POST['mobile'] = $_GET['user_mobile'];
	}
	
if(!isset($_POST['user_find'])){
	echo '<form method="post" role="form" class="form-inline">
			<label for="mobile"> شماره موبایل : </label>
			<input type="text" name="mobile" class="form-control" required>
			<input type="submit" name="user_find" value="جستجو"  class="form-control btn btn-md btn-primary">
		</form>';
}
?>
<?php

$error = '';

if(isset($_POST['go_update'])){
					$id=$_POST['id'];
					$first_name=$_POST['first_name'];
					$gender=$_POST['gender'];
					$marketers_id=$_POST['marketers_id'];
					$last_name=$_POST['last_name'];
					$melli_code=$_POST['melli_code'];
					$mobile=$_POST['mobile'];
					$tel=$_POST['tel'];
					$address=$_POST['address'];
					$postal_code=$_POST['postal_code'];
					$mail=$_POST['mail'];
					$zone=$_POST['zone'];
	if(true){
				$id=$_POST['id'];
				$update_profile_query="UPDATE users SET 
				melli_code='$melli_code',mobile='$mobile',zone='$zone'
				,tel='$tel',address='$address',gender='$gender',marketers_id='$marketers_id'
				,first_name='$first_name',last_name='$last_name'
				,postal_code='$postal_code',mail='$mail'
				 WHERE id='$id' ;";
				$update_profile_result=$mysqli->query($update_profile_query); 
				if($update_profile_result){
					$error = "<hr>
											<div class='col-lg-12 col-md-6'>
												<br style='margin:20px 0;'>
												<div class='alert alert-success alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
												 ویرایش اطلاعات حساب $first_name $last_name 		با موفقیت انجام شد.
												</div>
											</div>";
					}else{
						$error = "<hr>
											<div class='col-lg-12 col-md-6'>
												<br style='margin:20px 0;'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													فیلد های اجباری را پر نمایید.
												</div>
											</div>
										";;
						}
}
else{
	$error = "<hr>
											<div class='col-lg-12 col-md-6'>
												<br style='margin:20px 0;'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													خطا ! لطفا بعدا تلاش کنید.
												</div>
											</div>
										";;
	}
}
#################################################
if(isset($_POST['reset_password'])){
	$id = $_POST['id'];
	$password = sha1('1234');
	$reset_query="UPDATE users SET password='$password' WHERE id='$id' ;";
				$reset_result = $mysqli->query($reset_query); 
				if($reset_result){
					$error = "<hr>
											<div class='col-lg-12 col-md-6'>
												<br style='margin:20px 0;'>
												<div class='alert alert-success alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
												کلمه عبور شخص مورد نظر به 1234 تغییر پیدا کرد.
												</div>
											</div>
										";
					}else{
						$error = "<hr>
											<div class='col-lg-12 col-md-6'>
												<br style='margin:20px 0;'>
												<div class='alert alert-danger alert-dismissable'>
												  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
													خطا ! لطفا بعدا تلاش کنید.
												</div>
											</div>
										";
						}
}
###################################################
	
if(isset($_POST['user_find'])){
$mobile= $_POST['mobile'];
	$update_profile_query="SELECT * FROM users WHERE mobile='$mobile';";
	$update_profile_result=$mysqli->query($update_profile_query);
	$update_profile_row=$update_profile_result->fetch_assoc();
	$cart_pri= $update_profile_row['cart_pri'];
	$cart_sec= $update_profile_row['cart_sec'];
	$cart_ter= $update_profile_row['cart_ter'];
	$payerId= $update_profile_row['payerId'];
	$payerId2= $update_profile_row['payerId2'];
	$payerId3= $update_profile_row['payerId3'];
	$cart_pri_split=str_split($cart_pri,4);
	$cart_sec_split=str_split($cart_sec,4);
	$cart_ter_split=str_split($cart_ter,4);
	$id=$update_profile_row['id'];
	$first_name=$update_profile_row['first_name'];
	$last_name=$update_profile_row['last_name'];
	$gender=$update_profile_row['gender'];
	$melli_code=$update_profile_row['melli_code'];
	$mobile=$update_profile_row['mobile'];
	$zone=$update_profile_row['zone'];
	$tel=$update_profile_row['tel'];
	$address=$update_profile_row['address'];
	$postal_code=$update_profile_row['postal_code'];
	$mail=$update_profile_row['mail'];
	$marketers_id=$update_profile_row['marketers_id'];
}
?>
<?php echo $error; if(!isset($_POST['user_find'])) die();
		if(empty($update_profile_row['id'])){ die('موردی یافت نشد. <a href="index.php?page=users_edit">بازگشت</a>');}
?>
<div class="row">
    <div class="col-lg-12">

        	<form method="post" role="form" class="form-horizontal">
		
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="first_name"> نام : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text"  name="first_name" tabindex="1" class="form-control" value="<?php echo $first_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="last_name"> نام خانوادگی : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text"  name="last_name" tabindex="2" class="form-control" value="<?php echo $last_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="last_name"> جنسیت : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text"  name="gender" tabindex="2" class="form-control" value="<?php echo $gender; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="melli_code"> کد ملی : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text" name="melli_code" tabindex="3" autofocus class="form-control numeric" value="<?php echo $melli_code; ?>" maxlength="10">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="mobile"> تلفن همراه : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text" name="mobile" tabindex="4" class="form-control numeric" value="<?php echo $mobile; ?>" maxlength="11">   
                    </div>
                    <p class="help-block">از تلفن همراه جهت اطلاع از میزان سود سهام شما استفاده می کنیم.</p>
                </div>
                
                <?php
					$options = '';
								if($zone == 0){
											$options .= "<option value='0'>لطفا منطقه را انتخاب کنید</option>";
								}
						for($i = 1 ; $i<23 ; $i++){
							if($zone == $i){
							
										$options .= "<option selected>$i</option>";
										
									}else{
										
										$options .= "<option>$i</option>";
								}
						}
				?>
                <div class="form-group">
                	<label class="col-sm-2 col-xs-12  control-label pull-right" for="zone"> منطقه محل سکونت : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <select name="zone" class="form-control">
                            <!--<option value="0">منطقه محل سکونت</option>-->
                            <?php echo $options; ?>
                        </select>
                    </div>
            	</div>
                
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="tel"> کارت اول : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text" disabled name="cart_pri" tabindex="5" dir="ltr" class="form-control numeric" value="<?php echo $cart_pri.' : '.$payerId; ?>" maxlength="11">
                    </div>
                    <p class="help-block"><a target="_blank" style="color:red;" href="index.php?page=users_cards_edit&id=<?php echo $id; ?>">مدیریت کارت ها</a></p>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="tel"> کارت دوم : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text" disabled name="cart_sec" tabindex="5" dir="ltr" class="form-control numeric" value="<?php echo $cart_sec.' : '.$payerId2; ?>" maxlength="11">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="tel"> کارت سوم : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text" disabled name="cart_ter" tabindex="5" dir="ltr" class="form-control numeric" value="<?php echo $cart_ter.' : '.$payerId3; ?>" maxlength="11">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="tel"> تلفن ثابت : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text" name="tel" tabindex="5" class="form-control numeric" value="<?php echo $tel; ?>" maxlength="11">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="address"> آدرس : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <textarea lang="fa" name="address" tabindex="6" cols="5" class="form-control"><?php echo $address; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="postal_code"> کد پستی : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text" name="postal_code" tabindex="7" class="form-control numeric" value="<?php echo $postal_code; ?>" maxlength="10">
                    </div>
                     <p class="help-block">در صورتی که آدرس خود را وارد می کنید حتما کد پستی را هم وارد نمایید.</p>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="mail"> ایمیل : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" dir="ltr" style="font-family:verdana;" type="text" name="mail" tabindex="8" class="form-control" value="<?php echo $mail; ?>">  
                    </div>
                    <p class="help-block">از ایمیل شما جهت بازیابی رمز عبور و اطلاع رسانی اطلاعات خرید و میزان سود سهام شما استفاده می کنیم.</p>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12  control-label pull-right" for="tel"> کد بازاریابی : </label>
                    <div class="col-sm-4 col-md-3 col-xs-12 pull-right">
                        <input lang="fa" type="text" name="marketers_id" tabindex="5" class="form-control numeric" value="<?php echo $marketers_id; ?>" maxlength="11">
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="col-sm-2 pull-right"></div>
                <div class="col-sm-2 pull-right"> 
                    <input type="submit" class="btn btn-outline btn-success btn-block" name="go_update" value="تایید ویرایش" tabindex="9">
                </div>

            </form>
            <form method="post">
                <div class="col-sm-2 pull-right"> 
                    <input type='hidden' value='<?php echo $id; ?>' name='id' >
                    <input type='submit' name='reset_password' class='form-control btn btn-sm btn-warning' value='ریست پسورد به 1234' >
                </div>
            </form>
        
    </div>
</div>
