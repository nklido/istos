<?php
require('core/init.php');

if(!isset($_SESSION['user'])) {
	header("Location:login.php");
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="css/navigation.css" rel="stylesheet" type="text/css">
	<link href="css/profile.css" rel="stylesheet" type="text/css">
	<title>Reservations</title>
</head>
<body>
  <?php include('navigation.php');?>
	<?php include('navigation_profile.php'); ?>

	<div class="profile_content">
		<div id='bookings_profile_section'>
		<?php
			$Acc = new Accommodation();
			$data = $Acc->getBookedAccomsByUserId($_SESSION['user_id']);
			if($data != null){
				echo '<h1>Bookings Page</h1>';
				echo '<table><tr>';
				foreach($data as $index=> $booked_accom){
					$currentDate = date("Y-m-d");
					$days_left_msg = '';
					if($currentDate < $booked_accom['checkin_date']){
						$days_left = date_diff(date_create($booked_accom['checkin_date']),date_create($currentDate));
						$days_left  = $days_left->format("%R%a days");
						$days_left_msg = "<br>There are $days_left left!!";
					}

					$str = <<<EOF
					<td>
						<table>
							<tr>
								<td width='50%'><a href="accommodation.php?id={$booked_accom['accom_id']}"><img src="{$booked_accom['path_to_image']} "alt="Avatar" width="350" height="350"></td>
							</tr>
							<tr>
								<td align="center"><i>{$booked_accom['title']}</i></td>
							</tr>
							<tr>
								<td>You have <em>booked</em> this accommodation from <b>{$booked_accom['checkin_date']}</b> to <b>{$booked_accom['checkout_date']}</b>.{$days_left_msg}</td>
							</tr>
						</table>
					</td>
EOF;
					echo $str;
				}
				echo '</tr></table>';
			}else{ 	// No accomodations returned
				echo '<h2><i>You have no Bookings</i></h2>';
			}
?>
		</div>
	</div>
	<div id="footer">
		<p>
		</p>
	</div>
</body>
</html>
