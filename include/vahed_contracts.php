<?php if($unit_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست مالکین واحد</h3>
مجتمع تجاری اداری بوستان
    <table class="table table-striped table-hover table-bordered tablesorter">
    		<thead>
				<tr>
					<th>ردیف</th>
					<th>پلاک ثبتی</th>
                    <th>نام مالک</th>
                    <th>کد ملی</th>
					<th>درصدمالکیت</th>
                    <th>تاریخ عقد قرارداد</th>
                    <th>مدت قرارداد</th>
					<th>تصویر قولنامه</th>
                    <th>عکس پرسنلی</th>
                    <th>تصویر کارت ملی</th>
                    <th>تصویر سند</th>
				</tr>
            </thead>
            <tbody>
<?php
	$id = $_REQUEST['id'];
	
	$vahed_contracts_query = "SELECT 
								contract.id,contract.vahed_id,contract.users_id,contract.percent,contract.gholname_image,contract.begin_date,contract.duration,
								users.first_name,users.last_name,users.melli_code,users.personal_image,users.karte_melli_image,
								vahed.pelak_sabti,vahed.sanad
								 FROM `contract` 
									INNER JOIN users ON contract.users_id = users.id
									INNER JOIN vahed ON contract.vahed_id = vahed.id
								 WHERE contract.vahed_id = '$id' ";
	
	$vahed_contracts_result = $mysqli->query($vahed_contracts_query);		
		
	while($vahed_contracts_row = $vahed_contracts_result->fetch_assoc()){
		
		if($vahed_contracts_row['gholname_image']){
				$vahed_contracts_row['gholname_image'] = '<a target="_blank" href="images/gholname/'.$vahed_contracts_row['gholname_image'].'"><img src="images/gholname/'.$vahed_contracts_row['gholname_image'].'" width="30"></a>';
				}else{
				$vahed_contracts_row['gholname_image'] = '<span style="color:red">ندارد</span>';	
					}
					
		if($vahed_contracts_row['personal_image']){
				$vahed_contracts_row['personal_image'] = '<a target="_blank" href="images/users/personal/'.$vahed_contracts_row['personal_image'].'"><img src="images/users/personal/'.$vahed_contracts_row['personal_image'].'" width="30"></a>';
				}else{
				$vahed_contracts_row['personal_image'] = '<span style="color:red">ندارد</span>';	
					}
					
		if($vahed_contracts_row['karte_melli_image']){
				$vahed_contracts_row['karte_melli_image'] = '<a target="_blank" href="images/users/melli_card/'.$vahed_contracts_row['karte_melli_image'].'"><img src="images/users/melli_card/'.$vahed_contracts_row['karte_melli_image'].'" width="30"></a>';
				}else{
				$vahed_contracts_row['karte_melli_image'] = '<span style="color:red">ندارد</span>';	
					}
					
		if($vahed_contracts_row['sanad']){
				$vahed_contracts_row['sanad'] = '<a target="_blank" href="images/vahed/'.$vahed_contracts_row['sanad'].'"><img src="images/vahed/'.$vahed_contracts_row['sanad'].'" width="30"></a>';
				}else{
				$vahed_contracts_row['sanad'] = '<span style="color:red">ندارد</span>';	
					}
					$vahed_contracts_row['begin_date'] = jdate("Y/m/d",$vahed_contracts_row['begin_date']);
					
		echo "
		  <tr>
					<td>$vahed_contracts_row[id]</td>
					<td>$vahed_contracts_row[pelak_sabti]</td>
					<td>$vahed_contracts_row[first_name] $vahed_contracts_row[last_name]</td>
					<td>$vahed_contracts_row[melli_code]</td>
					<td>$vahed_contracts_row[percent]</td>
					<td>$vahed_contracts_row[begin_date]</td>
					<td>$vahed_contracts_row[duration] ماه</td>
					<td>$vahed_contracts_row[gholname_image]</td>
					<td>$vahed_contracts_row[personal_image]</td>
					<td>$vahed_contracts_row[karte_melli_image]</td>
					<td>$vahed_contracts_row[sanad]</td>
		  </tr>";	

	}
	
?>
</tbody>
</table>