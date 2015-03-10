<?php if($change_privileges == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">تغییر سطح دسترسی</h3>
<div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <tr>
					<th>ردیف</th>
                    <th>نام و نام خانوادگی</th>
					<th>موبایل</th>
                    <th>کد</th>
                    <th>نقش</th>
                    <th>امکانات</th>
				</tr>
<?php

$i = 1 ;
$mojavez='';

	
	

	$admins_query = "SELECT 
								 admins.first_name
								,admins.last_name
								,admins.mobile
								,admins.roles_id
								,roles.id
								,roles.title
								 FROM admins 
									INNER JOIN roles
											ON admins.roles_id = roles.id";
	//echo $mysqli->error;
	$admins_result = $mysqli->query($admins_query);
	
while($admins_row = $admins_result ->fetch_assoc()){
			$roles_id = $admins_row['roles_id'];

			$roles_query = "SELECT * FROM rolespermissions WHERE roles_id = '$roles_id' ; ";
			$roles_result = $mysqli->query($roles_query);	
			while($roles_row = $roles_result ->fetch_assoc()){
				$permissions_id = $roles_row['permissions_id'];
				
					$permissions_query = "SELECT * FROM permissions WHERE id = '$permissions_id' ; ";
					$permissions_result = $mysqli->query($permissions_query);	
					$permissions_row = $permissions_result ->fetch_assoc();
					$permissions_title = $permissions_row['title'];
					
				$mojavez .= $permissions_id.' - '.$permissions_title.'<br>';
			}
		
		echo "
		  <tr>
					<td>$i</td>
					<td>$admins_row[first_name] $admins_row[last_name]</td>
					<td>$admins_row[mobile]</td>
					<td>$admins_row[roles_id]</td>
					<td>$admins_row[title]</td>
					<td>$mojavez</td>		
		  </tr>";
		$i++;
}	
?>
</table>
</div>

