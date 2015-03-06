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
			
			if($users_row['sanad']){
				$users_row['sanad'] = '<a target="_blank" href="images/vahed/'.$users_row['sanad'].'"><span style="color:blue" class="glyphicon glyphicon-file"></span></a>';
				}else{
				$users_row['sanad'] = '<span style="color:red">ندارد</span>';	
					}
					
		echo "
			  <tr>
						<td>$users_row[id]</td>
						<td>$users_row[first_name] $vahed_row[last_name]</td>
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