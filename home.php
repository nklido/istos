<?php
require('core/init.php');
$accom = new Accommodation();

if (isset($_GET['location'])){
	$loc = escape($_GET['location']);
	echo $loc;
	if($loc !='show all'){
		$data = $accom->getAccomByLocation($loc);
	}else{
		header('location:home.php');
	}
}else{
	$data = $accom->getAccommodations();
}


$locations = $accom->getExistingLocations();
$search = '<form method="GET"><select id="location_select"><option value="all">show all</option>';
foreach($locations as $index => $location){
	if(isset($loc) && $loc == $location['location']){
		$selected = 'selected';
	}else {$selected='';}
 	$search.= <<< EOR
	<option value="{$location['location']}" {$selected}>{$location['location']}</option>
EOR;
}
$search .='</select></form>';
?>
<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="css/navigation.css" rel="stylesheet" type="text/css">
	<link href="css/home.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/location-select.js"></script>
	<title>Index</title>
</head>
<body>

	<?php
	echo  $search;
	include('navigation.php');
	?>
	<div class="main_div">
		<div class="content">
			<h2>Accomodations</h2>
			<?php
				echo '<table><tr>';
				if(isset($data)){
					foreach($data as $index=> $accomodation){
						if($index%4	==0)
							echo '<tr>';
						$str = <<<EOF
						<td>
							<div>
								<table id='accom'>
									<tr>
										<td><a href='accommodation.php?id={$accomodation['accom_id']}'><img class='home_acc' src="{$accomodation['path_to_image']}" alt="Avatar"></a></td>
									</tr>
									<tr>
										<td align="center"><i>{$accomodation['title']}</i></td>
									</tr>
								</table>
							</div>
						</td>
EOF;
						if($index%4==0)
							echo '</tr>';
						echo $str;
					}
					echo '</tr></table>';
			}
			?>
		</div>
		<!--
  	<img src="pictures/home.jpg" alt="home" class="center" width="1200" height="512">
	-->
	</div>
<hr>
<div id="footer">
  <p>
  </p>
</div>
</body>
