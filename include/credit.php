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
	$sum = 0;
	$count = 0;
	if(isset($_POST['go_credit'])){
	
		$credit_query = "SELECT * FROM transaction WHERE 1=1 ";
		if($_POST['fromdate'] && $_POST['todate']){
			$fromdate = $_POST['fromdate'];
			$todate = $_POST['todate'];
			$credit_query .= " AND settlementDate BETWEEN '$fromdate' AND '$todate' ";}
		
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

		
		$sum=number_format($sum,0,'.',',');
				
		$error = '<div class="col-lg-12 col-md-12">
												<br style="margin:20px 0;">
												<div class="alert alert-success alert-dismissable">
												  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												مجموع وجوه دریافتی در بازه ذکر شده مبلغ 
												'.'<b style="font-size:18px;">'.$sum.'</b>'.'
												ریال
												و تعداد تراکنش ها 
												'.'<b style="font-size:18px;">'.$count.'</b>'.'
												 می باشد.
												</div>
											</div>
										';

	}
 
?>

<div class="col-lg-12 col-md-12">
    <form method="post" role="form" class="form form-inline">
    	<label for="city">شهر : </label>
    	<select class="form-control" name="city">
        	<option>تهران</option>
            <option>تهران</option>
        </select>
        <label for="city">منطقه : </label>
        <select class="form-control" name="city">
        	<option>1</option>
            <option>2</option>
        </select>
        <label for="city">پذیرنده : </label>
        <select class="form-control" name="city">
        	<option>1447895 - تک منصور</option>
        </select>
        <label for="city">کارشناس : </label>
        <select class="form-control" name="city">
        	<option>حسن جاویدیان</option>
        </select><br>
    
    		<hr style="margin:20px 0;">
    	<label for="fromdate"> از تاریخ میلادی : </label><input type="text" class="form-control" name="fromdate" placeholder="2014/06/13">
        <label for="todate"> تا تاریخ میلادی : </label><input type="text" class="form-control" name="todate" placeholder="2014/06/14">
        
        <hr style="margin:20px 0;">
    	<label for="fromdatefa"> از تاریخ : </label>
        		<select class="form-control" name="fromdatefaday">
                	<option selected>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                   </option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option>
                </select>
                <select class="form-control" name="fromdatefamonth">
                	<option selected>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option>
                </select>                
                <select class="form-control" name="fromdatefayear">
                	<option selected>1393</option>
                    <option>1394</option>
                </select>
        <label for="todatefa"> تا تاریخ : </label>
        		<select class="form-control" name="todatefaday">
                	<option selected>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                   </option><option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option>
                </select>
                <select class="form-control" name="todatefamonth">
                	<option selected>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option>
                </select>                
                <select class="form-control" name="todatefayear">
                	<option selected>1393</option>
                    <option>1394</option>
                </select>
        <input type="submit" name="go_credit" value="دریافت موجودی" class="form-control btn btn-md btn-primary">
    </form>
</div>
<?php echo $error; ?>
<?php							
	$diagram_query = "SELECT * FROM ( SELECT * FROM diagram2 GROUP BY(day) ORDER BY day DESC LIMIT 20 ) AS r ORDER BY day ASC ; ";
    $diagram_result = $mysqli->query($diagram_query);

        $labels = array();
        $data   = array();
		$data2   = array();
    
        while ($diagram_row = $diagram_result->fetch_assoc()) {
            $labels[] = substr($diagram_row["day"],-5);
            $data[]   = $diagram_row["credit_count"];
			$data2[]   = $diagram_row["credit_amount"];
        }

        // Now you can aggregate all the data into one string
        $data_string = "[" . join(", ", $data) . "]";
		$data_string2 = "[" . join(", ", $data2) . "]";

        $labels_string = "['" . join("', '", $labels) . "']";
?>
<script src="js/jquery.js"></script>
<script src="js/RGraph.common.core.js" ></script>
<script src="js/RGraph.line.js" ></script>
    <hr><hr>
    <div class="col-sm-12" style="padding:0">
    <h4 class="sub-header">نمودار تعداد تراکنش ها</h4>
    <canvas id="cvs" width="1000" height="250" style="width:90%">[No canvas support]</canvas>
    <script>
        chart = new RGraph.Line('cvs', <?php print($data_string) ?>)
            .set('background.grid.autofit', true)
            .set('gutter.left', 75)
            .set('gutter.right', 25)
            .set('hmargin', 10)
            .set('tickmarks', 'endcircle')
            .set('labels', <?php print($labels_string) ?>)
            .draw();
			
    </script>
    </div>	
    <div class="col-sm-12" style="padding:0">
    <hr>
    <h4 class="sub-header">نمودار مبلغ سود</h4>
	<canvas id="cvs2" width="1000" height="250" style="width:90%">[No canvas support]</canvas>
	<script>
    		chart2 = new RGraph.Line('cvs2', <?php print($data_string2) ?>)
            .set('background.grid.autofit', true)
            .set('gutter.left', 75)
            .set('gutter.right', 25)
            .set('hmargin', 10)
            .set('tickmarks', 'endcircle')
			.set('chart.colors', ['blue','yellow'])
            .set('labels', <?php print($labels_string) ?>)
            .draw();
    </script>
    </div>