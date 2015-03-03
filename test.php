<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
    ### CONNECT TO DB ###
	$server_name="localhost";
	$username_db="sunnycart";
	$password_db="kosenanat:dD1369";
	$db_name="sunnycart";
	$mysqli=new mysqli($server_name,$username_db,$password_db,$db_name) or die("Connection Failed...!");
	$mysqli->set_charset("utf8");

    $diagram_query = "SELECT * FROM ( SELECT * FROM diagram ORDER BY id DESC LIMIT 10 ) AS r ORDER BY id ASC ; ";
    $diagram_result = $mysqli->query($diagram_query);

        $labels = array();
        $data   = array();
		$data2   = array();
    
        while ($diagram_row = $diagram_result->fetch_assoc()) {
            $labels[] = $diagram_row["day"];
            $data[]   = $diagram_row["transaction_count"];
			$data2[]   = $diagram_row["transaction_amount"];
			$data3[]   = $diagram_row["active_count"];
        }

        // Now you can aggregate all the data into one string
        $data_string = "[" . join(", ", $data) . "]";
		$data_string2 = "[" . join(", ", $data2) . "]";
		$data_string3 = "[" . join(", ", $data3) . "]";
        $labels_string = "['" . join("', '", $labels) . "']";

?>
<html>
<head>

    <!-- Don't forget to update these paths -->

    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

</head>
<body>
    <script src="js/RGraph.common.core.js" ></script>
    <script src="js/RGraph.line.js" ></script>
    <canvas id="cvs" width="800" height="250">[No canvas support]</canvas>
    <script>
        chart = new RGraph.Line('cvs', <?php print($data_string) ?>)
            .set('background.grid.autofit', true)
            .set('gutter.left', 75)
            .set('gutter.right', 25)
            .set('hmargin', 10)
            .set('tickmarks', 'endcircle')
            .set('labels', <?php print($labels_string) ?>)
            .draw();
			
    </script>
    <br>
	<canvas id="cvs2" width="800" height="250">[No canvas support]</canvas>
	<script>
    		chart2 = new RGraph.Line('cvs2', <?php print($data_string2) ?>)
            .set('background.grid.autofit', true)
            .set('gutter.left', 75)
            .set('gutter.right', 25)
            .set('hmargin', 10)
            .set('tickmarks', 'endcircle')
			.set('chart.colors', ['green','yellow'])
            .set('labels', <?php print($labels_string) ?>)
            .draw();
    </script>
    <br>
    <canvas id="cvs3" width="800" height="250">[No canvas support]</canvas>
    <script>
    		chart3 = new RGraph.Line('cvs3', <?php print($data_string3) ?>)
            .set('background.grid.autofit', true)
            .set('gutter.left', 75)
            .set('gutter.right', 25)
            .set('hmargin', 10)
            .set('tickmarks', 'endcircle')
			.set('chart.colors', ['blue','yellow'])
            .set('labels', <?php print($labels_string) ?>)
            .draw();
    </script>
</body>
</html>