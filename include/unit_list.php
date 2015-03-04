<?php if($unit_list == false){ die('شما مجوز دسترسی به این صفحه را ندارید.'); } ?>
<h3 class="sub-header">لیست واحد ها</h3>
مجتمع تجاری اداری بوستان
    <table class="table table-striped table-hover table-bordered tablesorter">
    		<thead>
				<tr>
					<th>ردیف</th>
					<th>پلاک ثبتی</th>
                    <th>پلاک آبی</th>
					<th>آدرس</th>
					<th>مساحت ثبتی</th>
                    <th>کنتوری مربوطه</th>
                    <th>شماره بدنه کنتور</th>
                    <th>شماره پرونده</th>
                    <th>نوع فاز</th>
                    <th>نوع کاربری</th>
                    <th>آب</th>
                    <th>پارکینگ</th>
                    <th>گاز</th>
                    <th>تلفن</th>
				</tr>
            </thead>
            <tbody>
<?php

	
	$vahed_query = "SELECT `id`, `radif`, `pelak_sabti`, `pelak_abi`, `address`, `masahat_sabti`, `kontori_marboote`, `shomare_badane_kontor`, `shomare_parvande`, `noe_faaz`, `noe_karbari`, `ab`, `parking`, `gaz`, `telephone` FROM `vahed` WHERE 1";
	
	$vahed_result = $mysqli->query($vahed_query);

	function daradNadarad($input){
		
		if($input == 1){
			return "<span style='color:green;'>دارد</span>";
			}else if ($input == 0){
			return "<span style='color:red;'>ندارد</span>";	
				}
		}
		
		
	while($vahed_row = $vahed_result->fetch_assoc()){
		
			$vahed_row['ab'] = daradNadarad($vahed_row['ab']);
			$vahed_row['parking'] = daradNadarad($vahed_row['parking']);
			$vahed_row['gaz'] = daradNadarad($vahed_row['gaz']);
			
		echo "
		  <tr>
					<td>$vahed_row[id]</td>
					<td>$vahed_row[pelak_sabti]</td>
					<td>$vahed_row[pelak_abi]</td>
					<td>$vahed_row[address]</td>
					<td>$vahed_row[masahat_sabti]</td>
					<td>$vahed_row[kontori_marboote]</td>
					<td>$vahed_row[shomare_badane_kontor]</td>
					<td>$vahed_row[shomare_parvande]</td>
					<td>$vahed_row[noe_faaz]</td>
					<td>$vahed_row[noe_karbari]</td>	
					<td>$vahed_row[ab]</td>
					<td>$vahed_row[parking]</td>
					<td>$vahed_row[gaz]</td>
					<td>$vahed_row[telephone]</td>	
		  </tr>";	

	}
	
?>
</tbody>
</table>