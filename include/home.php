<h3 class="sub-header">سخن روز</h3>
<div class="col-lg-12 col-md-12">
<?php
### GENERATED BY POOYA SABRAMOOZ ###
	error_reporting(E_ALL);
	ini_set('display_errors','1');
	date_default_timezone_set('Asia/Tehran');
	
### connect to db ###

	$connection = mysqli_connect('localhost','sunnycart','kosenanat:dD1369','sunnycart') OR die('FAILED...');
	mysqli_set_charset($connection, 'utf8');

#####################
	
	$quotations_query = "SELECT * FROM quotations ORDER BY RAND() LIMIT 1 ; ";
	$quotations_result = mysqli_query($connection,$quotations_query);
	$quotations_row = mysqli_fetch_assoc($quotations_result);
	
	$quotations_row['author'];

?>
<blockquote class="blockquote-reverse">
  <p><?php echo $quotations_row['text']; ?></p>
  <footer style="direction:rtl;color:#3399CC"><?php echo $quotations_row['author']; ?></footer>
</blockquote>
</div>