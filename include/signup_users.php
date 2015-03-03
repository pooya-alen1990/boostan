<?php if($signup_users == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">ثبت نام سهامداران</h3>
<?php 
$error ='';
error_reporting(E_ALL);
ini_set('display_errors','1');
include("../include/SendSimpleSMS2_SoapClient_mellipayamak.php");
date_default_timezone_set('Asia/Tehran');

	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");
#### FUNCTIONS ########
	function toSafeString($mysqli,$string){
			$string=$mysqli->real_escape_string($string);
			$string=htmlentities($string,ENT_QUOTES,"utf-8");
			$string=trim($string);
			return $string;
		}
	### card ####		
		function card_number($cart,$mysqli){
			$i = 1;
			$j = 1;
			$k = 1;	
			if(!empty($cart)){
				
				
				$check_cart_pri_query="SELECT id,cart_pri,payerId FROM users WHERE cart_pri='$cart' ORDER BY payerId desc LIMIT 1";
				$check_cart_pri_result=$mysqli->query($check_cart_pri_query);
				$check_cart_pri_rows=$check_cart_pri_result->fetch_assoc();
				$check_cart_pri_num_rows=$check_cart_pri_result->num_rows;
					if($check_cart_pri_num_rows>0){
						$i = $check_cart_pri_rows['payerId'] + 1;
						}
				
				$check_cart_sec_query="SELECT id,cart_sec,payerId2 FROM users WHERE cart_sec='$cart' ORDER BY payerId2 desc LIMIT 1";
				$check_cart_sec_result=$mysqli->query($check_cart_sec_query);
				$check_cart_sec_rows=$check_cart_sec_result->fetch_assoc();
				$check_cart_sec_num_rows=$check_cart_sec_result->num_rows;
					if($check_cart_sec_num_rows>0){
						$j = $check_cart_sec_rows['payerId2'] + 1;
						}
						
				$check_cart_ter_query="SELECT id,cart_ter,payerId3 FROM users WHERE cart_ter='$cart' ORDER BY payerId3 desc LIMIT 1";
				$check_cart_ter_result=$mysqli->query($check_cart_ter_query);
				$check_cart_ter_rows=$check_cart_ter_result->fetch_assoc();
				$check_cart_ter_num_rows=$check_cart_ter_result->num_rows;
					if($check_cart_ter_num_rows>0){
						$k = $check_cart_ter_rows['payerId3'] + 1;
						}
						
				return max($i,$j,$k);
			}
		}		
	function bank_name($card){
		$subcard = substr($card,0,6);
		switch($subcard){
			case '610433':$bank_name = 'بانک ملت';break;
			case '639599':$bank_name = 'بانك قوامين';break;
			case '636795':$bank_name = 'بانك مركزي';break;
			case '505809':$bank_name = 'بانك خاورميانه قدیم';break;
			case '585947':$bank_name = 'بانك خاورميانه جدید';break;
			case '622106':$bank_name = 'بانك پارسيان';break;
			case '636214':$bank_name = 'بانك آینده';break;
			case '502938':$bank_name = 'بانك دي';break;
			case '603770':$bank_name = 'بانك كشاورزي';break;
			case '504706':$bank_name = 'بانك شهر';break;
			case '636949':$bank_name = 'بانك حكمت ايرانيان';break;
			case '505785':$bank_name = 'بانك ايران زمين';break;
			case '505416':$bank_name = 'بانك گردشگري';break;
			case '627381':$bank_name = 'بانك انصار';break;
			case '502908':$bank_name = 'بانك توسعه تعاون';break;
			case '606373':$bank_name = 'بانك قرض الحسنه مهر ايران';break;
			case '628157':$bank_name = 'موسسه اعتباري توسعه';break;
			case '505801':$bank_name = 'موسسه اعتباري کوثر';break;
			case '606256':$bank_name = 'موسسه اعتباري عسکریه';break;
			case '639370':$bank_name = 'بانک مهر اقتصاد';break;
			case '639346':$bank_name = 'بانک سينا';break;
			case '627760':$bank_name = 'پست بانك';break;
			case '627648':$bank_name = 'بانک توسعه صادرات ایران';break;
			case '502229':$bank_name = 'بانك پاسارگاد';break;
			case '589463':$bank_name = 'بانك رفاه';break;
			case '627488':$bank_name = 'بانك كارآفرين';break;
			case '639607':$bank_name = 'بانك سرمايه';break;
			case '627412':$bank_name = 'بانك اقتصاد نوين';break;
			case '621986':$bank_name = 'بانك سامان';break;
			case '627961':$bank_name = 'بانك صنعت و معدن';break;
			case '628023':$bank_name = 'بانك مسكن';break;
			case '589210':$bank_name = 'بانك سپه';break;
			case '603769':$bank_name = 'بانك صادرات';break;
			case '603799':$bank_name = 'بانك ملي';break;
			case '504172':$bank_name = 'بانك رسالت';break;
			}
		return $bank_name;
		}	
?>
<?php 
$msg='';
if(isset($_POST['go_register'])){
	
	$first_name=toSafeString($mysqli,$_POST['first_name']);
	$last_name=toSafeString($mysqli,$_POST['last_name']);
	$password="1234";
	$repassword="1234";
	$password_hash=sha1($password);
	$gender=toSafeString($mysqli,$_POST['gender']);
	$mobile=toSafeString($mysqli,$_POST['mobile']);
	$bank=toSafeString($mysqli,$_POST['bank']);
	$cart_pri4=toSafeString($mysqli,$_POST['cart_pri4']);
	$cart_pri=$bank.'****'.$cart_pri4; 
	$settings_flag=3;
	$marketers_id=toSafeString($mysqli,$_POST['marketers_id']);
	$user_ip=$_POST['user_ip'];
	$shareholders_code=0;
	$city="تهران";
	$melli_code='';
	$tel='';
	$address='';
	$zone='';
	$mail='';
	$postal_code='';
	
	if(
	!empty($first_name)&&
	!empty($last_name)&&
	!empty($mobile)&&
	!empty($cart_pri4)&&
	!empty($bank)
	){
		
		//check new mobile
		$check_mobile_query="SELECT id,mobile FROM users WHERE mobile='$mobile'";
		$check_mobile_result=$mysqli->query($check_mobile_query);
		$check_mobile_rows=$check_mobile_result->num_rows;
		$check_mobile_result->close();

		$payerId = card_number($cart_pri,$mysqli);
		$payerId2 = 1;
		$payerId3 = 1;
		
		$bank_name = bank_name($cart_pri);
		if($check_mobile_rows==0){

				if($password==$repassword){
					$signup_user_query="CALL sp_users_insert('$first_name','$last_name','$melli_code','$password_hash','$gender','$mobile','$payerId','$payerId2','$payerId3','$cart_pri','$tel','$address','$zone','$postal_code','$mail','$city','$user_ip','$settings_flag','$shareholders_code','$marketers_id');";
					$register_result=$mysqli->query($signup_user_query);
					
				if($register_result){
						if($gender=='مرد'){$smsgender='آقای';}elseif($gender=='زن'){$smsgender='خانم';}		
					//send welcome sms
					$message = "$smsgender $last_name\nبه طرح سانی خوش آمدید\nشناسه واریز کارت $bank_name شما عدد $payerId و شناسه حساب همیشه عدد 1 می باشد.\nwww.scards.ir";
					pooya_sms($mobile,$message,$mysqli);
					//send welcome E-Mail
							$to=$mail;
							$subject='به سانی کارت خوش آمدید';
							$message="
								<html>
									<head><title></title></head>
									<body style='color:#999;' bgcolor='#666666'>
										<h3>سلام $first_name $last_name</h3>										
											<p>شناسه واریز شما عدد $payerId ،
											وشناسه حساب شما عدد 1 می باشد.</p>
										<p>
								برای ورود لطفا روی لینک زیر کلیک کنید 
							<a href='http://www.scards.ir/login.php' target='_blank'>ورود</a>
										</p>
									</body>
								</html>
							";
							$header="content-type:text/html;charset=utf-8";
							$header.="sunny cart <info@scards.ir>";
							//mail($to,$subject,$message,$header);
				
				$msg='ثبت نام با موفقیت انجام شد ، برای ویرایش یا اضافه کردن کارت <a href="index.php?page=users_edit&user_mobile='.$mobile.'">اینجا</a> کلیک کنید.';
				}
				else{
				$msg='خطا در ثبت،لطفا بعدا تلاش کنید.';
				}
				//}else{ $msg='لطفا قوانین و مقررات را خوانده و قبول کنید..'; }
				}
				else{
				$msg='کلمه عبور با تکرار آن مطابقت ندارد';
				}//close confirm password

						}
		else{
			$msg="شماره موبایل قبلا ثبت شده است. لطفا دوباره تلاش کنید.";
		}//close check new username
		
		
	}
	else{
		$msg='لطفا فیلدهای ستاره دار را پر نمایید.';	
	}
}
?>
<?php
	if($msg=='ثبت نام با موفقیت انجام شد ، برای ویرایش یا اضافه کردن کارت <a href="index.php?page=users_edit&user_mobile='.@$mobile.'">اینجا</a> کلیک کنید.'){
		echo "<div class='row'>
			<div class='col-lg-12 col-md-6'>
				<div class='alert alert-success alert-dismissable'>
				  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				  $msg
				</div>
			</div>
		</div>";
	}elseif(!empty($msg)){
		echo "<div class='row'>
			<div class='col-lg-12 col-md-6'>
				<div class='alert alert-danger alert-dismissable'>
				  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				  $msg
				</div>
			</div>
		</div>";
		}
?>
<script src="js/jquery.js"></script>
<script>
$(document).ready(function() {

	$("#bank_pri").change(function(){
			var banknumber = $("#bank_pri option:selected").val();
			$("#cart_pri_pish").val(banknumber+"****");		
		});
	
    $(".numeric").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	$(".autotab11").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab21").focus();
			}	
		});
		$(".autotab21").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab31").focus();
			}	
		});
		$(".autotab31").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab41").focus();
			}	
		});
			$(".autotab12").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab22").focus();
			}	
		});
		$(".autotab22").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab32").focus();
			}	
		});
		$(".autotab32").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab42").focus();
			}	
		});
			$(".autotab13").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab23").focus();
			}	
		});
		$(".autotab23").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab33").focus();
			}	
		});
		$(".autotab33").keyup(function(){
		var a = $(this).val();
		if(a.length==4){
			$(".autotab43").focus();
			}	
		});
});
</script>
<form method="post" role="form" class="form-horizontal col-xs-4 pull-right" dir="rtl">
  <div class="form-group">
            
           <div class="col-xs-8"><input id="first_name" class="form-control" type="text" name="first_name" tabindex="1" autofocus></div>
           <label class="control-label col-sm-4" for="first_name">نام : </label>
  </div>   
  <div class="form-group">        
            
            <div class="col-xs-8">
            <input class="form-control" type="text" name="last_name" tabindex="2">
            </div>
            <label class="control-label col-sm-4" for="last_name">نام خانوادگی : </label>
  </div>
  
  <div class="form-group">
                <div class="col-xs-8">
                    <select name="gender" tabindex="4" class="form-control">
                    	<option value="مرد">مرد</option><option value="زن">زن</option>
                    </select>
                </div>
                    <label class="control-label col-sm-4" for="last_name">جنسیت : </label>     
   </div>
    <div class="form-group">         
                  
            <div class="col-xs-8"><input class="form-control numeric" type="text" name="mobile" tabindex="15" maxlength="11"></div>
            <label class="control-label col-sm-4" for="receptor_mobile">تلفن همراه : </label>       
    </div>

   <div class="form-group">
                    
                    <div class="col-xs-8">
						<select tabindex="4" id="bank_pri" name="bank" class="form-control">
                            <option value="">لطفا بانک مورد نظر را انتخاب نمایید</option>
                            <option value="610433**">بانك ملت</option>
                            <option value="639599**">بانك قوامين</option>
                            <option value="636795**">بانك مركزي</option>
                            <option value="505809**">بانك خاورميانه قدیم</option>
                            <option value="585947**">بانك خاورميانه جدید</option>
                            <option value="622106**">بانك پارسيان</option>
                            <option value="636214**">بانك آینده</option>
                            <option value="502938**">بانك دي</option>
                            <option value="603770**">بانك كشاورزي</option>
                            <option value="504706**">بانك شهر</option>
                            <option value="636949**">بانك حكمت ايرانيان</option>
                            <option value="505785**">بانك ايران زمين</option>
                            <option value="505416**">بانك گردشگري</option>
                            <option value="627381**">بانك انصار</option>
                            <option value="502908**">بانك توسعه تعاون</option>
                            <option value="606373**">بانك قرض الحسنه مهر ايران</option>
                            <option value="628157**">موسسه اعتباري توسعه</option>
                            <option value="505801**">موسسه اعتباري کوثر</option>
                            <option value="606256**">موسسه اعتباري عسکریه</option>
                            <option value="639370**">بانک مهر اقتصاد</option>
                            <option value="639346**">بانک سينا</option>
                            <option value="627760**">پست بانك</option>
                            <option value="627648**">بانک توسعه صادرات ایران</option>
                            <option value="502229**">بانك پاسارگاد</option>
                            <option value="589463**">بانك رفاه</option>
                            <option value="627488**">بانك كارآفرين</option>
                            <option value="639607**">بانك سرمايه</option>
                            <option value="627412**">بانك اقتصاد نوين</option>
                            <option value="621986**">بانك سامان</option>
                            <option value="627961**">بانك صنعت و معدن</option>
                            <option value="628023**">بانك مسكن</option>
                            <!-- <option value="627353**">بانك تجارت</option>-->
                            <option value="589210**">بانك سپه</option>
                            <option value="603769**">بانك صادرات</option>
                            <option value="603799**">بانك ملي</option>
                            <option value="504172**">بانك رسالت</option>                
                        </select>
                    </div>
                    <label class="control-label col-sm-4" for="bank">انتخاب بانک : </label>
                </div> 
                   
                <div class="form-group">
                     
                    
                    <div class="col-sm-3 col-xs-6" dir="ltr" style="min-width:140px !important;">
                    		<input id="cart_pri_pish" type="text" class="form-control" disabled >
                    </div>
                    
                    <div class="col-sm-3 col-xs-6">
							<input type="text" name="cart_pri4" class="form-control pull-right numeric" maxlength="4" >
                    </div>
                    
                    <label class="control-label col-sm-4" for="cart_pri4">شماره کارت اول : </label>
                </div>

   <input type="hidden" name="user_ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    
    <div class="form-group">         
                  
            <div class="col-xs-8"><input class="form-control numeric" type="text" name="marketers_id" tabindex="15" maxlength="3"></div>
            <label class="control-label col-sm-4" for="marketers_id">کد بازاریاب : </label>       
    </div>
      
            <!--<input type="reset" value="ویرایش" class="form-control btn btn-warning" tabindex="16"><br><br>-->
       
            <input type="submit" name="go_register" class="form-control btn btn-primary" value="ثبت نام" tabindex="17">  
</form>