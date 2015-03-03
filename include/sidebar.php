<?php
	$users_list = false;
	$users_list_tabriz = false;
	$users_edit = false;
	$receptors_list = false;
	$receptors_list_tabriz = false;
	$reader = false;
	$contactus_list = false;
	$marketers_list = false;
	$datereader = false;
	$newsletter_list = false;
	$transactions_list = false;
	$unknown_list = false;
	$transactions_list_tabriz = false;
	$unknown_list_tabriz = false;
	$mail_group_send = false;
	$sms_management = false;
	$sms_group_send = false;
	$credit = false;
	$change_privileges = false;
	$taraz = false;
	$signup_receptors = false;
	$advance_search = false;
	$stock_management = false;
	$stock_list = false;
	$leaders_list = false;
	$stock_sale_list = false;
	$follow_list = false;
	$receptors_stat = false;
	$signup_users = false;
	
	#################################3
	$unit_list = false;
	
	
	$home_active='';$messages_active='';
	$users_list_active='';$users_list_tabriz_active='';$users_edit_active='';$receptors_list_active='';$receptors_list_tabriz_active='';$reader_active='';
	$contactus_list_active='';$marketers_list_active='';$datereader_active='';
	$newsletter_list_active='';$transactions_list_active='';$unknown_list_active='';$transactions_list_tabriz_active='';$unknown_list_tabriz_active='';$mail_group_send_active='';
	$sms_management_active='';$sms_group_send_active='';$credit_active='';$change_privileges_active='';
	$taraz_active='';$signup_receptors_active='';$advance_search_active='';$stock_management_active='';$stock_list_active='';
	$leaders_list_active='';$stock_sale_list_active='';$follow_list_active='';$receptors_stat_active='';$signup_users_active='';
	
	######################
	$unit_list_active='';
	
	if(in_array('users_list',$_SESSION['permissions'])){ $users_list = true; }
	if(in_array('users_list_tabriz',$_SESSION['permissions'])){ $users_list_tabriz = true; }
	if(in_array('users_edit',$_SESSION['permissions'])){ $users_edit = true; }
	if(in_array('receptors_list',$_SESSION['permissions'])){ $receptors_list = true; }
	if(in_array('receptors_list_tabriz',$_SESSION['permissions'])){ $receptors_list_tabriz = true; }
	if(in_array('reader',$_SESSION['permissions'])){ $reader = true; }
	if(in_array('contactus_list',$_SESSION['permissions'])){ $contactus_list = true; }
	if(in_array('marketers_list',$_SESSION['permissions'])){ $marketers_list = true; }
	if(in_array('datereader',$_SESSION['permissions'])){ $datereader = true; }
	if(in_array('newsletter_list',$_SESSION['permissions'])){ $newsletter_list = true; }
	if(in_array('transactions_list',$_SESSION['permissions'])){ $transactions_list = true; }
	if(in_array('unknown_list',$_SESSION['permissions'])){ $unknown_list = true; }
	if(in_array('transactions_list_tabriz',$_SESSION['permissions'])){ $transactions_list_tabriz = true; }
	if(in_array('unknown_list_tabriz',$_SESSION['permissions'])){ $unknown_list_tabriz = true; }
	if(in_array('mail_group_send',$_SESSION['permissions'])){ $mail_group_send = true; }
	if(in_array('sms_management',$_SESSION['permissions'])){ $sms_management = true; }
	if(in_array('sms_group_send',$_SESSION['permissions'])){ $sms_group_send = true; }
	if(in_array('credit',$_SESSION['permissions'])){ $credit = true; }
	if(in_array('change_privileges',$_SESSION['permissions'])){ $change_privileges = true; }
	if(in_array('taraz',$_SESSION['permissions'])){ $taraz = true; }
	if(in_array('signup_receptors',$_SESSION['permissions'])){ $signup_receptors = true; }
	if(in_array('advance_search',$_SESSION['permissions'])){ $advance_search = true; }
	if(in_array('stock_management',$_SESSION['permissions'])){ $stock_management = true; }
	if(in_array('stock_list',$_SESSION['permissions'])){ $stock_list = true; }
	if(in_array('leaders_list',$_SESSION['permissions'])){ $leaders_list = true; }
	if(in_array('stock_sale_list',$_SESSION['permissions'])){ $stock_sale_list = true; }
	if(in_array('follow_list',$_SESSION['permissions'])){ $follow_list = true; }
	if(in_array('receptors_stat',$_SESSION['permissions'])){ $receptors_stat = true; }
	if(in_array('signup_users',$_SESSION['permissions'])){ $signup_users = true; }
	
	
	#####################################################
	if(in_array('unit_list',$_SESSION['permissions'])){ $unit_list = true; }
	
		
?>
<div class="col-sm-3 col-md-2 sidebar">
  <ul class="nav nav-sidebar">
<?php 
	
	
	 if(isset($_GET['page']) && $_GET['page']=='home'){ $home_active = 'active'; } 
     	echo "<li class='$home_active' ><a href='index.php?page=home'>داشبورد من</a></li>"; 
    
	
	 if(isset($_GET['page']) && $_GET['page']=='messages'){ $messages_active = 'active'; } 
     	echo "<li class='$messages_active' ><a href='index.php?page=messages'>پیام های من</a></li>"; 
     

	 if(isset($_GET['page']) && $_GET['page']=='unit_list'){ $unit_list_active = 'active'; } 
     	if($unit_list == true){ echo "<li class='$unit_list_active' ><a href='index.php?page=unit_list'>لیست واحد ها</a></li>";}
		
		
	 if(isset($_GET['page']) && $_GET['page']=='transactions_list'){ $transactions_list_active = 'active'; } 
     	if($transactions_list == true){ echo "<li class='$transactions_list_active' ><a href='index.php?page=transactions_list'>لیست خرید ها</a></li>";}
		
	if(isset($_GET['page']) && $_GET['page']=='transactions_list_tabriz'){ $transactions_list_tabriz_active = 'active'; } 
     	if($transactions_list_tabriz == true){ echo "<li class='$transactions_list_tabriz_active' ><a href='index.php?page=transactions_list_tabriz'>لیست خرید های تبریز</a></li>";}	
	
	
	if(isset($_GET['page']) && $_GET['page']=='unknown_list'){ $unknown_list_active = 'active'; } 
     	if($unknown_list == true){ echo "<li class='$unknown_list_active' ><a href='index.php?page=unknown_list'>لیست معوقات</a></li>";}
		
	if(isset($_GET['page']) && $_GET['page']=='unknown_list_tabriz'){ $unknown_list_tabriz_active = 'active'; } 
     	if($unknown_list_tabriz == true){ echo "<li class='$unknown_list_tabriz_active' ><a href='index.php?page=unknown_list_tabriz'>لیست معوقات تبریز</a></li>";}	
	
	
	if(isset($_GET['page']) && $_GET['page']=='sms_management'){ $sms_management_active = 'active'; }
    	if($sms_management == true){ echo "<li class='$sms_management_active' ><a href='index.php?page=sms_management'>مدیریت اس ام اس ها</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='credit'){ $credit_active = 'active'; }
    	if($credit == true){ echo "<li class='$credit_active' ><a href='index.php?page=credit'>گزارش وجوه دریافتی</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='taraz'){ $taraz_active = 'active'; }
    	if($taraz == true){ echo "<li class='$taraz_active' ><a href='index.php?page=taraz'>گزارش تراز</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='advance_search'){ $advance_search_active = 'active'; }
    	if($advance_search == true){ echo "<li class='$advance_search_active' ><a href='index.php?page=advance_search'>جستجو پیشرفته</a></li>";}
  echo '</ul>
  <ul class="nav nav-sidebar">';
  
  
  if(isset($_GET['page']) && $_GET['page']=='contactus_list'){ $contactus_list_active = 'active'; }
    	if($contactus_list == true){ echo "<li class='$contactus_list_active' ><a href='index.php?page=contactus_list'>گزارش ارتباط با ما</a></li>";}
	
  if(isset($_GET['page']) && $_GET['page']=='follow_list'){ $follow_list_active = 'active'; }
    	if($follow_list == true){ echo "<li class='$follow_list_active' ><a href='index.php?page=follow_list&pages=1'>لیست پیگیری</a></li>";}
		
  if(isset($_GET['page']) && $_GET['page']=='signup_users'){ $signup_users_active = 'active'; }
    	if($signup_users == true){ echo "<li class='$signup_users_active' ><a href='index.php?page=signup_users'>ثبت نام سهامداران</a></li>";}
	
	if(isset($_GET['page']) && $_GET['page']=='users_list'){ $users_list_active = 'active'; }
    	if($users_list == true){ echo "<li class='$users_list_active' ><a href='index.php?page=users_list&pages=1'>لیست سهامداران</a></li>";}
		
	if(isset($_GET['page']) && $_GET['page']=='users_list_tabriz'){ $users_list_tabriz_active = 'active'; }
    	if($users_list_tabriz == true){ echo "<li class='$users_list_tabriz_active' ><a href='index.php?page=users_list_tabriz&pages=1'>لیست سهامداران تبریز</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='users_edit'){ $users_edit_active = 'active'; }
    	if($users_edit == true){ echo "<li class='$users_edit_active' ><a href='index.php?page=users_edit'>ویرایش سهامداران</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='receptors_stat'){ $receptors_stat_active = 'active'; }
    	if($receptors_stat == true){ echo "<li class='$receptors_stat_active' ><a href='index.php?page=receptors_stat'>آمار پذیرندگان</a></li>";}
		
		
	if(isset($_GET['page']) && $_GET['page']=='receptors_list'){ $receptors_list_active = 'active'; }
    	if($receptors_list == true){ echo "<li class='$receptors_list_active' ><a href='index.php?page=receptors_list'>لیست پذیرندگان</a></li>";}
		
	if(isset($_GET['page']) && $_GET['page']=='receptors_list_tabriz'){ $receptors_list_tabriz_active = 'active'; }
    	if($receptors_list_tabriz == true){ echo "<li class='$receptors_list_tabriz_active' ><a href='index.php?page=receptors_list_tabriz'>لیست پذیرندگان تبریز</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='signup_receptors'){ $signup_receptors_active = 'active'; }
    	if($signup_receptors == true){ echo "<li class='$signup_receptors_active' ><a href='index.php?page=signup_receptors'>ثبت نام پذیرندگان</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='marketers_list'){ $marketers_list_active = 'active'; }
    	if($marketers_list == true){ echo "<li class='$marketers_list_active' ><a href='index.php?page=marketers_list'>لیست بازاریابان</a></li>";}
		
	if(isset($_GET['page']) && $_GET['page']=='leaders_list'){ $leaders_list_active = 'active'; }
    	if($leaders_list == true){ echo "<li class='$leaders_list_active' ><a href='index.php?page=leaders_list'>لیست سرتیم ها</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='newsletter_list'){ $newsletter_list_active = 'active'; }
    	if($newsletter_list == true){ echo "<li class='$newsletter_list_active' ><a href='index.php?page=newsletter_list'>لیست خبرنامه</a></li>";}
 echo  '</ul>
  <ul class="nav nav-sidebar">';
  
  
  if(isset($_GET['page']) && $_GET['page']=='mail_group_send'){ $mail_group_send_active = 'active'; }
    	if($mail_group_send == true){ echo "<li class='$mail_group_send_active' ><a href='index.php?page=mail_group_send'>ارسال ایمیل تکی و گروهی</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='sms_group_send'){ $sms_group_send_active = 'active'; }
    	if($sms_group_send == true){ echo "<li class='$sms_group_send_active' ><a href='index.php?page=sms_group_send'>ارسال اس ام اس تکی و گروهی</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='datereader'){ $datereader_active = 'active'; }
    	if($datereader == true){ echo "<li class='$datereader_active' ><a href='index.php?page=datereader'>تراکنش ها برای همه پذیرنده ها</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='reader'){ $reader_active = 'active'; }
    	if($reader == true){ echo "<li class='$reader_active' ><a href='index.php?page=reader'>تراکنش ها به تفکیک پذیرنده ها</a></li>";}
	
	if(isset($_GET['page']) && $_GET['page']=='stock_management'){ $stock_management_active = 'active'; }
    	if($stock_management == true){ echo "<li class='$stock_management_active' ><a href='index.php?page=stock_management'>مدیریت سهام</a></li>";}
	
	if(isset($_GET['page']) && $_GET['page']=='stock_list'){ $stock_list_active = 'active'; }
    	if($stock_list == true){ echo "<li class='$stock_list_active' ><a href='index.php?page=stock_list'>سالنامه سهامداران</a></li>";}
		
	if(isset($_GET['page']) && $_GET['page']=='stock_sale_list'){ $stock_sale_list_active = 'active'; }
    	if($stock_sale_list == true){ echo "<li class='$stock_sale_list_active' ><a href='index.php?page=stock_sale_list'>لیست فروش سهام</a></li>";}
	
	if(isset($_GET['page']) && $_GET['page']=='change_privileges'){ $change_privileges_active = 'active'; }
    	if($change_privileges == true){ echo "<li class='$change_privileges_active' ><a href='index.php?page=change_privileges'>تغییر سطح دسترسی</a></li>";}
?>   
  </ul>
</div>