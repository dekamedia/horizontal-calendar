<?php
//get list of date in a month
function get_data($input_month = false, $input_year = false){
	if(!$input_month) $input_month = date('m');
	if(!$input_year) $input_year = date('Y');
	
	$out = false;
	$day_start = 1;
	$day_end = date('t', strtotime( $input_year . '-' . $input_month . '-01' ));
	for($i = $day_start; $i <= $day_end; $i++){
		$date_int = strtotime( $input_year . '-' . $input_month . '-' . $i );
		$out[] = [
					'int' => $date_int,
					'str' => date('Y-m-d', $date_int),
					'day' => $i,
					'month' => $input_month,
					'year' => $input_year,
					'day_code' => date('w', $date_int),
					'day_name' => date('l', $date_int),
				 ];
	}
	return $out;
}

//display calendar horizontally 
function display_horizontally($arr){
	if(!is_array($arr)) return false;

	$num_cols = 7; //number of columns (number of days in a week)
	$num_rows = 5; //number of rows (maximum 5 weeks in a month)

	//header
	$header = date('F Y', $arr[0]['int']);
	$header_days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
	
	//output start
	$out = '<table border="1">';

	//main header
	$out .= '<caption>'. $header .'</caption>';

	//weekdays name
	$out .= '<tr>';
	for($i = 0; $i <= $num_cols - 1; $i++){
		$out .= '<th>' . $header_days[$i] . '</th>';
	}
	$out .= '</tr>';
	
	//init date output
	$td = false;
	for($row = 0; $row < $num_rows; $row++){
		for($col = 0; $col < $num_cols; $col++){
			$td[$row][$col] = false;
		}
	}

	//start to fill the date
	$row = 0;
	foreach($arr as $index => $r){
		$the_row = $row;
		$the_col = $r['day_code'];
		$td[$the_row][$the_col] = $r['day'];
		
		if($the_col == $num_cols - 1){
			$row++;
		}
	}

	//output data
	for($row = 0; $row < $num_rows; $row++){
		$out .= '<tr>';
		for($col = 0; $col < $num_cols; $col++){
			$out .= '<td>' . $td[$row][$col] . '</td>';
		}
		$out .= '</tr>';
	}

	//output end
	$out .= '</table>';
	
	return $out;
}

$arr = get_data();
echo display_horizontally($arr);
