<?php
function stock_amount($from,$to,$mobile,$mysqli){
	$i = 1 ;
	$sum = 0;	
	$transactions_query = "SELECT 
								 transaction.amount
								,transaction.pan
								,transaction.settlementDate
								,transaction.settlementTime
								,transaction.payerId
								,transaction.terminalId
								,receptors.receptor_name
								,receptors.city
								,users.id
								,users.first_name
								,users.last_name
								,users.mobile
								 FROM transaction 
									INNER JOIN receptors
											ON transaction.terminalId = receptors.terminal_id
									INNER JOIN users
											ON transaction.pan = users.cart_pri AND transaction.payerId = users.payerId
											OR transaction.pan = users.cart_sec AND transaction.payerId = users.payerId2
											OR transaction.pan = users.cart_ter AND transaction.payerId = users.payerId3
									WHERE 1 = 1 
										AND (transaction.settlementDate BETWEEN '$from' AND '$to') 
										AND (users.mobile = '$mobile') ;
									";
				
	$transactions_result = $mysqli->query($transactions_query);
	$testcount = 0 ;
	while($transactions_row = $transactions_result ->fetch_assoc()){
		###########################################################################################################
		$test = '';
	
	$cart_query="SELECT * FROM users WHERE id='$transactions_row[id]';";
	$cart_result=$mysqli->query($cart_query);
	$cart_row=$cart_result->fetch_assoc();
	$cart_pri= $cart_row['cart_pri'];
	$cart_sec= $cart_row['cart_sec'];
	$cart_ter= $cart_row['cart_ter'];
	$payerId= $cart_row['payerId'];
	$payerId2= $cart_row['payerId2'];
	$payerId3= $cart_row['payerId3'];
	
	$transaction_query = "SELECT * FROM transaction WHERE (pan='$cart_pri' AND payerId='$payerId') 
																	OR (pan='$cart_sec' AND payerId='$payerId2') 
																			OR (pan='$cart_ter' AND payerId='$payerId3') ; ";
	$transaction_result = $mysqli->query($transaction_query);
	$sum1 = 0;
	$amountsum1 = 0;
	$count_users_tarakonesh = 0;
	while($transaction_row=$transaction_result->fetch_assoc()){
		$amount1 = '';
		if($transaction_row['accountNumber']=='4975553214'){
			
			$terminalid = $transaction_row['terminalId'];
			$terminalid_query="SELECT * FROM receptors WHERE terminal_id='$terminalid'; ";
			$terminalid_result=$mysqli->query($terminalid_query);
			$terminalid_row=$terminalid_result->fetch_assoc();
			
			if($terminalid_row['discount'] != 0){
			$amount1 = ($transaction_row['amount']*100)/$terminalid_row['discount'];
			}

			$sum1 = $sum1 + $amount1;
		if($sum1 != 0){
			$count_users_tarakonesh++;
			}

				$amountsum1 = $transaction_row['amount']+$amountsum1;		
		}		
	}
		
		###########################################################################################################

		$sum = $sum + $transactions_row['amount'];		

		$i++;
		}
return $sum;
}	

function stock_count($stock_amount,$price_per_share){
	return floor($stock_amount/$price_per_share);
	}
function stock_remain($stock_amount,$price_per_share){
	return ($stock_amount%$price_per_share);
	}
?>