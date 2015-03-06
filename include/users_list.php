<?php if($users_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست مالکین</h3>
مجتمع تجاری اداری بوستان
    <table class="table table-striped table-hover table-bordered tablesorter">
    		<thead>
				<tr>
					<th>ردیف</th>
					<th>نام و نام خانوادگی</th>
                    <th>کد ملی</th>
					<th>موبایل</th>
					<th>تلفن</th>
                    <th>آدرس</th>
                    <th>تاریخ تولد</th>
                    <th>عکس پرسنلی</th>
                    <th>تصویر کارت ملی</th>
				</tr>
            </thead>
            <tbody>
<?php

	
	$users_query = "SELECT * FROM `users`";
	
	$users_result = $mysqli->query($users_query);

		
		
	while($users_row = $users_result->fetch_assoc()){
			
			if($users_row['karte_melli_image']){
				$users_row['karte_melli_image'] = '<a target="_blank" href="images/users/melli_card/'.$users_row['karte_melli_image'].'"><img src="images/users/melli_card/'.$users_row['karte_melli_image'].'" width="30"></a>';
				}else{
				$users_row['karte_melli_image'] = '<span style="color:red">ندارد</span>';	
					}
			
			if($users_row['personal_image']){
				$users_row['personal_image'] = '<a target="_blank" href="images/users/personal/'.$users_row['personal_image'].'"><img src="images/users/personal/'.$users_row['personal_image'].'" width="30"></a>';
				}else{
				$users_row['personal_image'] = '<span style="color:red">ندارد</span>';	
					}
				$users_row['birthday'] = jdate("Y/m/d",$users_row['birthday']);	
		echo "
			  <tr>
						<td>$users_row[id]</td>
						<td>$users_row[first_name] $users_row[last_name]</td>
						<td>$users_row[melli_code]</td>
						<td>$users_row[mobile]</td>
						<td>$users_row[tel]</td>
						<td>$users_row[address]</td>
						<td>$users_row[birthday]</td>
						<td>$users_row[personal_image]</td>
						<td>$users_row[karte_melli_image]</td>
			  </tr>";	

	}
	
?>
</tbody>
</table>