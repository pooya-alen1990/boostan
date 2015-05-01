<?php
	$users_list = false;
	$users_edit = false;
	$change_privileges = false;
	$signup_users = false;
	$unit_list = false;
	$add_contract = false;
	
	
	$home_active='';$messages_active='';
	$users_list_active='';$users_edit_active='';$signup_users_active='';
	$unit_list_active='';$change_privileges_active='';$add_contract_active='';
	
	if(in_array('users_list',$_SESSION['permissions'])){ $users_list = true; }
	if(in_array('users_edit',$_SESSION['permissions'])){ $users_edit = true; }
	if(in_array('change_privileges',$_SESSION['permissions'])){ $change_privileges = true; }
	if(in_array('signup_users',$_SESSION['permissions'])){ $signup_users = true; }
	if(in_array('unit_list',$_SESSION['permissions'])){ $unit_list = true; }
	if(in_array('add_contract',$_SESSION['permissions'])){ $add_contract = true; }
	
		
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
		
	if(isset($_GET['page']) && $_GET['page']=='users_list'){ $users_list_active = 'active'; } 
     	if($users_list == true){ echo "<li class='$users_list_active' ><a href='index.php?page=users_list'>لیست مالکین</a></li>";}
				
	
	if(isset($_GET['page']) && $_GET['page']=='users_edit'){ $users_edit_active = 'active'; }
    	if($users_edit == true){ echo "<li class='$users_edit_active' ><a href='index.php?page=users_edit'>ویرایش مالکین</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='signup_users'){ $signup_users_active = 'active'; }
    	if($signup_users == true){ echo "<li class='$signup_users_active' ><a href='index.php?page=signup_users'>ثبت نام مالکین</a></li>";}
	
	if(isset($_GET['page']) && $_GET['page']=='add_contract'){ $add_contract_active = 'active'; }
    	if($add_contract == true){ echo "<li class='$add_contract_active' ><a href='index.php?page=add_contract'>اضافه کردن قرارداد</a></li>";}
	
	
	if(isset($_GET['page']) && $_GET['page']=='change_privileges'){ $change_privileges_active = 'active'; }
    	if($change_privileges == true){ echo "<li class='$change_privileges_active' ><a href='index.php?page=change_privileges'>تغییر سطح دسترسی</a></li>";}
?>   
  </ul>
</div>