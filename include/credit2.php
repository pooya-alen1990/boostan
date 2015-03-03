<?php if($credit == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">گزارش وجوه دریافتی</h3>				
<?php
	include('jdf.php');
	error_reporting(E_ALL);
	ini_set('display_errors','1');
	date_default_timezone_set('Asia/Tehran');
	$error ='';
	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");
	
function test($adad,$mysqli){
	$_POST['go_credit'] =1;
	$_POST['fromdatefayear'] = 1393;
	$_POST['todatefayear'] = 1393;
	
	$_POST['todatefamonth'] = 12;
	$_POST['fromdatefamonth'] = 12;
	
	$_POST['fromdatefaday'] = $adad;
	$_POST['todatefaday'] = $adad;
	
	$sum = 0;
	$count = 0;
	if(isset($_POST['go_credit'])){
	
		$credit_query = "SELECT * FROM transaction WHERE 1=1 ";
		//if($_POST['fromdate'] && $_POST['todate']){
//			$fromdate = $_POST['fromdate'];
//			$todate = $_POST['todate'];
//			$credit_query .= " AND settlementDate BETWEEN '$fromdate' AND '$todate' ";}
		
		if($_POST['fromdatefayear'] && $_POST['fromdatefamonth']){
			$fromdateeng = jalali_to_gregorian($_POST['fromdatefayear'],$_POST['fromdatefamonth'],$_POST['fromdatefaday']);
				if(strlen($fromdateeng[1])==1){$fromdateeng[1] = '0'.$fromdateeng[1];}
				if(strlen($fromdateeng[2])==1){$fromdateeng[2] = '0'.$fromdateeng[2];}
				$fromdateeng = $fromdateeng[0].'/'.$fromdateeng[1].'/'.$fromdateeng[2];
			$todateeng = jalali_to_gregorian($_POST['todatefayear'],$_POST['todatefamonth'],$_POST['todatefaday']);
				if(strlen($todateeng[1])==1){$todateeng[1] = '0'.$todateeng[1];}
				if(strlen($todateeng[2])==1){$todateeng[2] = '0'.$todateeng[2];}
				$todateeng = $todateeng[0].'/'.$todateeng[1].'/'.$todateeng[2];

			$credit_query .= " AND settlementDate BETWEEN '$fromdateeng' AND '$todateeng' ";
			}
			
			
		/*if($_POST['text2']){
			$credit_query .= " AND text2_field like '%$_POST[text2]%' ";}
		
		if($_POST['text3']){
			$credit_query .= " AND text3_field like '%$_POST[text3]%' ";}*/
		
		
		$credit_result=$mysqli->query($credit_query);
		while($credit_row=$credit_result->fetch_assoc()){
			
			//echo $credit_row['settlementDate'].'<br>';
				 $sum = $credit_row['amount'] + $sum;
				 $count++;
				
		}

		
		//$sum=number_format($sum,0,'.',',');
				
		//$error = '<div class="col-lg-12 col-md-12">
//												<br style="margin:20px 0;">
//												<div class="alert alert-success alert-dismissable">
//												  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
//												مجموع وجوه دریافتی در بازه ذکر شده مبلغ 
//												'.'<b style="font-size:18px;">'.$sum.'</b>'.'
//												ریال
//												و تعداد تراکنش ها 
//												'.'<b style="font-size:18px;">'.$count.'</b>'.'
//												 می باشد.
//												</div>
//											</div>
//										';

	}
	echo '<td> tedad : '.$count.'</td>
	<td> mablagh : '.$sum.'</td>
	<td> rooz : '.$_POST['fromdatefayear'].'/'.$_POST['fromdatefamonth'].'/'.$_POST['fromdatefaday'].'</td>
	';
}
echo '<table class="table table-bordered">';
for($i=1;$i<32;$i++){
	echo '<tr>';
	test($i,$mysqli);
	echo '</tr>';
	}
echo '</table>';
?>