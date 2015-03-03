<?php
$envelope = '';
//$curlTerminalId = '1446412';
$curlUsername = 'sgsj14';
$curlPassword = '57091096';
########
date_default_timezone_set('Asia/Tehran');
$FromDate = date('Ymd');
$ToDate = date('Ymd');
$customerId = '2715672';
########
$fromRecordId = '100131249265';
########
$referenceId = '100390284740';
########
$CustomerIdfromDate = date('Ymd');
$CustomerIdtoDate = date('Ymd');
########

if(isset($_POST['getTransactionByDate'])){
	$curlTerminalId = $_POST['curlTerminalId'];
	$FromDate = $_POST['FromDate'];
	$ToDate = $_POST['ToDate'];
$envelope = '<soap:Envelope xmlns:bpm="http://bpmellat.co/" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
   <soap:Header>
      <wsse:Security soap:mustUnderstand="true" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
         <wsu:Timestamp wsu:Id="Timestamp-8" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
            <wsu:Created>'.date('Y-m-d').'T16:02:38.053Z</wsu:Created>
            <wsu:Expires>'.date('Y-m-d').'T16:03:38.053Z</wsu:Expires>
         </wsu:Timestamp>
         <wsse:UsernameToken wsu:Id="UsernameToken-7" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
            <wsse:Username>'.$curlUsername.'</wsse:Username>
            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$curlPassword.'</wsse:Password>
            <wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">D5L5sjDemfkf/bq5zn7DMA==</wsse:Nonce>
            <wsu:Created>'.date('Y-m-d').'T16:02:34.714Z</wsu:Created>
         </wsse:UsernameToken>
      </wsse:Security>
   </soap:Header>
   <soap:Body>
      <bpm:getTransactionByDate>
         <bpm:TerminalId>'.$curlTerminalId.'</bpm:TerminalId>
         <bpm:FromDate>'.$FromDate.'</bpm:FromDate>
         <bpm:ToDate>'.$ToDate.'</bpm:ToDate>
      </bpm:getTransactionByDate>
   </soap:Body>
</soap:Envelope>';

}elseif(isset($_POST['getTransactionById'])){
	$referenceId = $_POST['referenceId'];
	$envelope = '<soap:Envelope xmlns:bpm="http://bpmellat.co/" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
   <soap:Header>
      <wsse:Security soap:mustUnderstand="true" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
         <wsu:Timestamp wsu:Id="TS-FF681FCD3EA851262913996992504281">
            <wsu:Created>'.date('Y-m-d').'T05:20:50.427Z</wsu:Created>
            <wsu:Expires>'.date('Y-m-d').'T05:21:50.427Z</wsu:Expires>
         </wsu:Timestamp>
<wsse:UsernameToken wsu:Id="UsernameToken-7" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
            <wsse:Username>'.$curlUsername.'</wsse:Username>
            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$curlPassword.'</wsse:Password>
            <wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">D5L5sjDemfkf/bq5zn7DMA==</wsse:Nonce>
            <wsu:Created>'.date('Y-m-d').'T16:02:34.714Z</wsu:Created>
         </wsse:UsernameToken>
      </wsse:Security>
   </soap:Header>
   <soap:Body>
      <bpm:getTransactionById>
         <bpm:referenceId>'.$referenceId.'</bpm:referenceId>
      </bpm:getTransactionById>
   </soap:Body>
</soap:Envelope>';
	
}
elseif(isset($_POST['getTransactionByCustomerId'])){
	$customerId = $_POST['customerId'];
	$CustomerIdfromDate = $_POST['CustomerIdfromDate'];
	$CustomerIdtoDate = $_POST['CustomerIdtoDate'];
	$fromRecordId = $_POST['fromRecordId'];
$envelope = '<soap:Envelope xmlns:bpm="http://bpmellat.co/" xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
   <soap:Header>
      <wsse:Security soap:mustUnderstand="true" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
         <wsu:Timestamp wsu:Id="TS-FF681FCD3EA851262913997025754219">
            <wsu:Created>'.date('Y-m-d').'T06:16:15.421Z</wsu:Created>
            <wsu:Expires>'.date('Y-m-d').'T06:17:15.421Z</wsu:Expires>
         </wsu:Timestamp>
		 <wsse:UsernameToken wsu:Id="UsernameToken-7" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
            <wsse:Username>'.$curlUsername.'</wsse:Username>
            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$curlPassword.'</wsse:Password>
            <wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">D5L5sjDemfkf/bq5zn7DMA==</wsse:Nonce>
            <wsu:Created>'.date('Y-m-d').'T16:02:34.714Z</wsu:Created>
         </wsse:UsernameToken>
      </wsse:Security>
   </soap:Header>
   <soap:Body>
      <bpm:getTransactionByCustomerId>
         <bpm:customerId>'.$customerId.'</bpm:customerId>
         <bpm:fromDate>'.$CustomerIdfromDate.'</bpm:fromDate>
         <bpm:toDate>'.$CustomerIdtoDate.'</bpm:toDate>
         <bpm:fromRecordId>'.$fromRecordId.'</bpm:fromRecordId>
      </bpm:getTransactionByCustomerId>
   </soap:Body>
</soap:Envelope>';	
}
?>
<?php
if(isset($_POST['min_database1'])){
	
	$min_database1_query="DELETE FROM `transaction` WHERE payerId=0";
	mysqli_query($connection,$min_database1_query);
		
	}elseif(isset($_POST['min_database2'])){
		
	$min_database2_query="DELETE FROM `transaction` WHERE accountNumber<>4975553214";
	mysqli_query($connection,$min_database2_query);		
		
	}
?>
<form method="post" role="form" class="form-inline">
<fieldset>
<h4>گرفتن تراکنش ها با تاریخ : </h4>
<label>شماره پایانه : </label>
	<select name="curlTerminalId" class="form-control">
    	<?php
		$terminal_id_query="SELECT terminal_id,receptor_name,activate FROM receptors WHERE terminal_id > 1 AND activate = '1' ;";
		$terminal_id_result=mysqli_query($connection,$terminal_id_query);
		while($terminal_id = mysqli_fetch_assoc($terminal_id_result)){
			echo "<option value='$terminal_id[terminal_id]'>".$terminal_id['terminal_id'].' - '.$terminal_id['receptor_name']."</option>";	
			};		
		 ?>
    </select>
<label>از تاریخ : </label><input class="form-control" type="text" name="FromDate" value="<?php echo $FromDate; ?>">
<label>تا تاریخ : </label><input class="form-control" type="text" name="ToDate" value="<?php echo $ToDate; ?>">
<input type="submit" name="getTransactionByDate" value="دریافت اطلاعات" class="btn btn-sm btn-success form-control">
</form>
<br><hr color="#FF0000" size="1"><br>
<form method="post"  role="form" class="form-inline">
<h4>گرفتن تراکنش ها با شناسه : </h4>
<label>شماره مرجع : </label><input class="form-control" type="text" name="referenceId" value="<?php echo $referenceId; ?>">
<input type="submit" name="getTransactionById" value="دریافت اطلاعات" class="btn btn-sm btn-success form-control">
</form>
<br><hr color="#FF0000" size="1"><br>
<form method="post"  role="form" class="form-inline">
<h4>گرفتن تراکنش ها با شناسه پذیرنده : </h4>
<label>شناسه پذیرنده : </label><input class="form-control" type="text" name="customerId" value="<?php echo $customerId; ?>">
<label>از تاریخ : </label><input class="form-control" type="text" name="CustomerIdfromDate" value="<?php echo $CustomerIdfromDate; ?>">
<label>تا تاریخ : </label><input class="form-control" type="text" name="CustomerIdtoDate" value="<?php echo $CustomerIdtoDate; ?>">
<label>از شناسه ثبت شده : </label><input class="form-control" type="text" name="fromRecordId" value="<?php echo $fromRecordId; ?>">
<input type="submit" name="getTransactionByCustomerId" value="دریافت اطلاعات" class="btn btn-sm btn-success form-control">
</fieldset>
</form>
<br><hr color="#FF0000" size="1"><br>
<form method="post"  role="form" class="form-inline">
	<input type="submit" value="مرحله اول تنظیم دیتابیس" name="min_database1" class="form-control btn btn-md btn-warning">
    <input type="submit" value="مرحله دوم تنظیم دیتابیس" name="min_database2" class="form-control btn btn-md btn-primary">
</form>
<br><hr color="#FF0000" size="1"><br>