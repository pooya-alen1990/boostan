<?php if($users_edit == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<?php
######## manage cart #########
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
		


####### SMS FUNCTION #########

	function pooya_sms($pooya_to,$pooya_message,$connection){
		ini_set("soap.wsdl_cache_enabled", "0");
		$sms_client = new SoapClient('http://melipayamak.ir/post/send.asmx?wsdl', array('encoding'=>'UTF-8'));
		
		$parameters['username'] = "9124077897";
		$parameters['password'] = "3755";
		$parameters['to'] = $pooya_to;
		$parameters['from'] = "2188806627";
		$parameters['text'] =$pooya_message;
		$parameters['isflash'] =false;
		
		$recId = $sms_client->SendSimpleSMS2($parameters)->SendSimpleSMS2Result;
		$date=time();
		
		$mysqli = $connection;
		//$send_sms_query="INSERT INTO sms(`id`, `mobile`, `text`, `recId`, `date`) VALUES ('','$pooya_to','$pooya_message','$recId','$date')";
		//$send_sms_result=$mysqli->query($send_sms_query);
		$send_sms_query = "INSERT INTO sms(`id`, `mobile`, `text`, `recId`, `date`) VALUES ('','$pooya_to','$pooya_message','$recId','$date')";
		$send_sms_result = mysqli_query($connection,$send_sms_query);
		return $recId;
		}
	
#####################	
	
define("MANAGE_CART_SUCCESS",'
<div class="col-lg-12">
		  <br style="margin:20px 0;">
		  <div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		 کارت با موفقیت اضافه شد.
		  </div>
</div>
');
define("MANAGE_CART_SUCCESS1",'
<div class="col-lg-12">
		  <br style="margin:20px 0;">
		  <div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		 کارت با موفقیت حذف شد.
		  </div>
</div>
');
define("MANAGE_CART_FAILED1",'
<div class="col-lg-12">
		  <br style="margin:20px 0;">
		  <div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		خطا در سیستم ، لطفا بعدا تلاش کنید.
		  </div>
</div>
');
define("MANAGE_CART_FAILED2",'
<div class="col-lg-12">
		  <br style="margin:20px 0;">
		  <div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		شماره کارت وارد شده تکراری می باشد.
		  </div>
</div>
');
define("MANAGE_CART_FAILED3",'
<div class="col-lg-12">
		  <br style="margin:20px 0;">
		  <div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		این کارت قبلا توسط شما ثبت شده است.
		  </div>
</div>
');
define("MANAGE_CART_FAILED4",'
<div class="col-lg-12">
		  <br style="margin:20px 0;">
		  <div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		لطفا بانک مورد نظر را انتخاب کنید.
		  </div>
</div>
');

$error= '';

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
##################################################################################

include('jdf.php');
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
	
	
//$id=$_SESSION['MM_id'];
if(isset($_GET['id'])){
$id=$_GET['id'];
	$user_query="SELECT * FROM users WHERE id='$id';";
	$user_result=$mysqli->query($user_query);
	$user_row=$user_result->fetch_assoc();
}else{
	die();
	}
if(isset($_POST['cart_pri4'])){
	  $cart_pri4=$_POST['cart_pri4'];
	  $bank_pri=$_POST['bank_pri'];
	  $cart_pri=$bank_pri.'****'.$cart_pri4; 
	
			//check new cart_number		
		$check_cart_query="SELECT 
		id,cart_pri,cart_sec,cart_ter FROM users WHERE cart_pri='$cart_pri' OR cart_sec='$cart_pri' OR cart_ter='$cart_pri' ;";
		$check_cart_result=$mysqli->query($check_cart_query);
		$check_cart_rows=$check_cart_result->num_rows;
		$check_cart_result->close();
		if($check_cart_rows==0){
			//update query
			$add_cart_pri_query="UPDATE users
					SET cart_pri='$cart_pri' WHERE id='$id';";
			$add_cart_pri_result=$mysqli->query($add_cart_pri_query);
				if($add_cart_pri_result){
					$error = MANAGE_CART_SUCCESS;
					}else{
						$error = MANAGE_CART_FAILED1;}
			}
		else{$error = MANAGE_CART_FAILED2;}
}
elseif(isset($_POST['go_register2'])){
	if(!empty($_POST['bank_sec']) && !empty($_POST['cart_sec4'])){
	  	  $cart_sec4=$_POST['cart_sec4'];
	 	  $bank_sec=$_POST['bank_sec'];
	  	  $cart_sec=$bank_sec.'****'.$cart_sec4;
		 		  
		  
			$check_query = "SELECT id,cart_pri,cart_sec,cart_ter FROM users WHERE id='$id' AND (cart_pri='$cart_sec' OR 
																									 cart_sec='$cart_sec' OR 
																									 		cart_ter='$cart_sec' ) ";
			$check_result=$mysqli->query($check_query);
			$check_row = $check_result->fetch_assoc();
			
			if(!empty($check_row)){$error = MANAGE_CART_FAILED3;}else{
		  ##############
		  $payerId2 = card_number($cart_sec,$mysqli);
		  ##############

			$add_cart_sec_query="UPDATE users SET cart_sec='$cart_sec',payerId2='$payerId2' WHERE id='$id';";
			$add_cart_sec_result=$mysqli->query($add_cart_sec_query);
			

				if($add_cart_sec_result){
					
					##############################################
					$bank_name = bank_name($cart_sec);
					$gender = $user_row['gender'];
					$last_name = $user_row['last_name'];
					$mobile = $user_row['mobile'];
						if($gender=='مرد'){$smsgender='آقای';}elseif($gender=='زن'){$smsgender='خانم';}		
					//send welcome sms
					$message = "$smsgender $last_name\nشناسه واریز کارت $bank_name شما عدد $payerId2 و شناسه حساب همیشه عدد 1 می باشد.\nwww.scards.ir";
					pooya_sms($mobile,$message,$mysqli);
					##############################################
					
					
					$error = MANAGE_CART_SUCCESS;
					}else{
						$error = MANAGE_CART_FAILED1;}}
	}else{$error = MANAGE_CART_FAILED4;}
}
elseif(isset($_POST['go_register3'])){
	if(!empty($_POST['bank_ter']) && !empty($_POST['cart_ter4'])){
	  		  $cart_ter4=$_POST['cart_ter4'];
			  $bank_ter=$_POST['bank_ter'];
			  $cart_ter=$bank_ter.'****'.$cart_ter4;

			$check_query = "SELECT id,cart_pri,cart_sec,cart_ter FROM users WHERE id='$id' AND (cart_pri='$cart_ter' OR 
																									 cart_sec='$cart_ter' OR 
																									 		cart_ter='$cart_ter' ) ";
			$check_result=$mysqli->query($check_query);
			$check_row = $check_result->fetch_assoc();
			
			if(!empty($check_row)){$error = MANAGE_CART_FAILED3;}else{
				
		  
		  ##############
		  $payerId3 = card_number($cart_ter,$mysqli);
		  ##############

			$add_cart_ter_query="UPDATE users
					SET cart_ter='$cart_ter',payerId3='$payerId3' WHERE id='$id';";
			$add_cart_ter_result=$mysqli->query($add_cart_ter_query);
				if($add_cart_ter_result){
					
					##############################################
					$bank_name = bank_name($cart_ter);
					$gender = $user_row['gender'];
					$last_name = $user_row['last_name'];
					$mobile = $user_row['mobile'];
						if($gender=='مرد'){$smsgender='آقای';}elseif($gender=='زن'){$smsgender='خانم';}		
					//send welcome sms
					$message = "$smsgender $last_name\nشناسه واریز کارت $bank_name شما عدد $payerId3 و شناسه حساب همیشه عدد 1 می باشد.\nwww.scards.ir";
					pooya_sms($mobile,$message,$mysqli);
					##############################################
					
					
					$error = MANAGE_CART_SUCCESS;
					}else{
					$error = MANAGE_CART_FAILED1;}}
	}else{$error = MANAGE_CART_FAILED4;}
}
elseif(isset($_POST['go_delete2'])){	  
			$delete_cart_sec_query="UPDATE users
					SET cart_sec='' WHERE id='$id';";
			$delete_cart_sec_result=$mysqli->query($delete_cart_sec_query);
				if($delete_cart_sec_result){
					$error = MANAGE_CART_SUCCESS1;
				}

}
elseif(isset($_POST['go_delete3'])){	  
			$delete_cart_ter_query="UPDATE users
					SET cart_ter='' WHERE id='$id';";
			$delete_cart_ter_result=$mysqli->query($delete_cart_ter_query);
				if($delete_cart_ter_result){
					$error = MANAGE_CART_SUCCESS1;
				}

}
?>
<?php
	$flag1=0;
	$flag2=0;
	$flag3=0;

	$cart_query="SELECT * FROM users WHERE id='$id';";
	$cart_result=$mysqli->query($cart_query);
	$cart_row=$cart_result->fetch_assoc();
	
	$cart_pri= $cart_row['cart_pri'];
	$cart_sec= $cart_row['cart_sec'];
	$cart_ter= $cart_row['cart_ter'];
	
	$payerId = $cart_row['payerId'];
	$payerId2 = $cart_row['payerId2'];
	$payerId3 = $cart_row['payerId3'];
	
	$cart_pri_split=str_split($cart_pri,4);
	$cart_sec_split=str_split($cart_sec,4);
	$cart_ter_split=str_split($cart_ter,4);
		if(strlen($cart_pri)>12){$flag1=1;}
		if(strlen($cart_sec)>12){$flag2=2;}
		if(strlen($cart_ter)>12){$flag3=3;}
?>
<script src="js/jquery.js"></script>
<script>
$(document).ready(function() {

	$("#bank_sec").change(function(){
			var banknumber = $("#bank_sec option:selected").val();
			$("#cart_sec_pish").val(banknumber+"****");		
		});
	$("#bank_ter").change(function(){
			var banknumber = $("#bank_ter option:selected").val();
			$("#cart_ter_pish").val(banknumber+"****");
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
<div class="row">
    <div class="col-md-6 pull-right">
        <h3 class="page-header">مدیریت کارت ها</h3>
				<p class="alert alert-success">توجه داشته باشید که شناسه حساب همیشه عدد <span style='color:red; font-weight:bold;'>1</span> می باشد.</p>
	
     <form method="post" role="form" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12  control-label pull-right" for="category">شماره کارت اول : </label>
                    <div class="col-sm-6 col-xs-12 pull-right">
                        <input type="text" dir="ltr" class="form-control" value="<?php echo $cart_pri;?>" <?php if($flag1==1){echo 'disabled';}?> >
                    </div>
                </div>
     </form>
	  <?php echo "<span style='color:#555; font-size:12px;'>شناسه واریز شما برای این کارت عدد <span style='color:red; font-weight:bold;'>$payerId</span> می باشد.</span>"; ?>
      <hr>
     <form method="post" role="form" class="form-horizontal">
   				<div class="form-group">
                    <label class="col-sm-3 col-xs-12  control-label pull-right" for="category">انتخاب بانک : </label>
                    <div class="col-sm-6 col-xs-12 pull-right">
						<select tabindex="4" id="bank_sec" name="bank_sec" class="form-control">
                            <option value="">  ---   لطفا بانک مورد نظر را انتخاب نمایید   ---  </option>
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
                </div>    
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12  control-label pull-right" for="category">شماره کارت دوم : </label> 
                    <div class="col-sm-3 col-xs-6 pull-right">
							<input type="text" dir="ltr" name="cart_sec4" class="form-control pull-right numeric" maxlength="4" value="<?php echo @$cart_sec_split['3'];?>" <?php if($flag2==2){echo 'disabled';}?> >
                    </div>
                    <div class="col-sm-3 col-xs-6 pull-right" dir="ltr" style="min-width:130px !important;">
                    		<input id="cart_sec_pish" type="text" style="padding:0 0 0 12px" class="form-control" disabled value="<?php if(!empty($cart_sec_split['0'])&&!empty($cart_sec_split['1'])&&!empty($cart_sec_split['2']))echo $cart_sec_split['0'].$cart_sec_split['1'].$cart_sec_split['2']; ?>" >
                    </div>
                </div>
                <div class="col-sm-2 pull-right">
               		 <input type="submit" class="btn btn-success btn-outline" value="ثبت کارت" name="go_register2"  tabindex="10">
                </div>
                <div class="col-sm-2 pull-right">
  					 <input type="submit" class="btn btn-danger btn-outline" value="حذف کارت" name="go_delete2" tabindex="11">
                </div>
     </form>
     	<div class="clearfix"></div>
	   <?php if(!empty($cart_sec)){ echo "<span style='color:#555; font-size:12px;'>شناسه واریز شما برای این کارت عدد <span style='color:red; font-weight:bold;'>$payerId2</span> می باشد.</span>";} ?>  
       <hr>
     <form method="post" role="form" class="form-horizontal">
   				<div class="form-group">
                    <label class="col-sm-3 col-xs-12  control-label pull-right" for="category">انتخاب بانک : </label>
                    <div class="col-sm-6 col-xs-12 pull-right">
						<select tabindex="4" id="bank_ter" name="bank_ter" class="form-control">
                            <option value="">  ---   لطفا بانک مورد نظر را انتخاب نمایید   ---  </option>
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
                </div>    
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12  control-label pull-right" for="category">شماره کارت سوم : </label> 
                    <div class="col-sm-3 col-xs-6 pull-right">
							<input type="text" dir="ltr" name="cart_ter4" class="form-control pull-right numeric" maxlength="4" value="<?php echo @$cart_ter_split['3'];?>" <?php if($flag3==3){echo 'disabled';}?> >
                    </div>
                    <div class="col-sm-3 col-xs-6 pull-right" dir="ltr" style="min-width:130px !important;">
                    		<input id="cart_ter_pish" type="text" style="padding:0 0 0 12px" class="form-control" disabled value="<?php if(!empty($cart_ter_split['0'])&&!empty($cart_ter_split['1'])&&!empty($cart_ter_split['2']))echo $cart_ter_split['0'].$cart_ter_split['1'].$cart_ter_split['2']; ?>" >
                    </div>
                </div>
                <div class="col-sm-2 pull-right">
               		 <input type="submit" class="btn btn-success btn-outline" value="ثبت کارت" name="go_register3"  tabindex="10">
                </div>
                <div class="col-sm-2 pull-right">
  					 <input type="submit" class="btn btn-danger btn-outline" value="حذف کارت" name="go_delete3" tabindex="11">
                </div>
     </form>
     	<div class="clearfix"></div>
	   <?php if(!empty($cart_ter)){ echo "<span style='color:#555; font-size:12px;'>شناسه واریز شما برای این کارت عدد <span style='color:red; font-weight:bold;'>$payerId3</span> می باشد.</span>";} ?>  
       <hr>
     <?php echo $error; ?>
</div>
</div>
