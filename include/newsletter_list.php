<?php if($newsletter_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست خبرنامه</h3>
<div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <tr>
					<th>ردیف</th>
					<th>ایمیل</th>              
				</tr>
<?php
include('jdf.php');
error_reporting(E_ALL);
ini_set('display_errors','1');
date_default_timezone_set('Asia/Tehran');
$i = 1 ;
	### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");

	
	$every_newsletter_query="SELECT * FROM newsletter;";
	$every_newsletter_result=$mysqli->query($every_newsletter_query);
	
	while($every_newsletter_row=$every_newsletter_result->fetch_assoc()){
	### Gozaresh giri ###
	
	echo "
		  <tr>
					<td>$i</td>
					<td>$every_newsletter_row[mail]</td>
		  </tr>";
	$i++;
}
?>
</table>
</div>