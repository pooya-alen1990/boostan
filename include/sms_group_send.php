<?php if($sms_group_send == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">ارسال اس ام اس تکی و گروهی</h3>
<?php
### GENERATED BY POOYA SABRAMOOZ ###
	error_reporting(E_ALL);
	ini_set('display_errors','1');
	include('jdf.php');
	date_default_timezone_set('Asia/Tehran');
	$error ='';

	ini_set('post_max_size' , '0' );  
	ini_set('max_execution_time' , '0');
	ini_set('max_input_time' , '0');
	ini_set('memory_limit' , '0');


### connect to db ###

	$connection = mysqli_connect('localhost','sunnycart','kosenanat:dD1369','sunnycart') OR die('FAILED...');
	mysqli_set_charset($connection, 'utf8');
			
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
	if(isset($_POST['groupSend'])){
		
	$fetch_users_query = "SELECT mobile,first_name,last_name,gender FROM users WHERE id>'1276' ; ";
	$fetch_users_result = mysqli_query($connection,$fetch_users_query);
		while($fetch_users_row = mysqli_fetch_assoc($fetch_users_result)){
				$mobile = $fetch_users_row['mobile'];
				$first_name = $fetch_users_row['first_name'];
				$last_name = $fetch_users_row['last_name'];
				$gender = $fetch_users_row['gender'];
				$text = $_POST['text'];		
									if(isset($gender)){
											if($gender=='مرد'){$smsgender='آقای';}elseif($gender=='زن'){$smsgender='خانم';}
										$message="$smsgender $last_name\n$text\n88806627\nwww.scards.ir
												  ";
										pooya_sms($mobile,$message,$connection);
										$error = '
											<div class="col-lg-12 col-md-6">
												<br style="margin:20px 0;">
												<div class="alert alert-success alert-dismissable">
												  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												  اس ام اس گروهی مورد نظر ارسال شد.
												</div>
											</div>
										';
									}
		}

	}
	
	elseif(isset($_POST['Send'])){
				$to = $_POST['to'];
				$text = $_POST['text'];		
				$message=$text;				
				pooya_sms($to,$message,$connection);
					$error = '
											<div class="col-lg-12 col-md-6">
												<br style="margin:20px 0;">
												<div class="alert alert-success alert-dismissable">
												  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												  اس ام اس مورد نظر ارسال شد.
												</div>
											</div>
										';
	}
?>
<div class="col-lg-6 col-md-6">
    <form method="post" role="form" class="form">
        <textarea name="text" class="form-control" rows="6"></textarea><br>
        <input type="submit" name="groupSend" value="ارسال به تمامی سهامداران" class="form-control btn btn-md btn-danger" onClick="return myfunction();">
    </form>
</div>
<div class="col-lg-6 col-md-6">
    <form method="post" role="form" class="form">
    	<input type="text" class="form-control" name="to" placeholder="شماره موبایل شخص مورد نظر را وارد نمایید"><br>
        <textarea name="text" class="form-control" rows="3" style="height:97px;"></textarea><br>
        <input type="submit" name="Send" value="ارسال" class="form-control btn btn-md btn-success">
    </form>
</div>

<?php echo $error; ?>

<script>
   function myfunction(){
    		var password = prompt("لطفا رمز ارسال اس ام اس گروهی را وارد کنید");

			if (password!=null && password=='1234568') {
				return true;
			}return false;
}
</script>