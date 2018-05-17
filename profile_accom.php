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
	<title>Accomodations</title>
</head>
<body>
  <?php include('navigation.php');?>
	<?php include('navigation_profile.php'); ?>

	<div class="profile_content">
		<div id='accom_profile_section'>

			<?php
				$Acc = new Accommodation();
				$data = $Acc->getAccomsByUserId($_SESSION['user_id']);
				/* sizeOf($data) kai count($data) petaei warning. */
				if($data != null){
					echo '<h1>My Accommodations</h1>';
					echo '<table><tr>';
					foreach($data as $index=> $accomodation){
						$user = new User();
						$bookings = $user->getUserBookingsByAccomId($accomodation['accom_id']);
						if($index%3	==0)
							echo '<tr>';
						$str = <<<EOF
						<td>
							<table>
								<tr>
									<td width='50%'><a href="accommodation.php?id={$accomodation['accom_id']}"><img src="{$accomodation['path_to_image']} "alt="Avatar" width="350" height="350"></td>
								</tr>
								<tr>
									<td align="center"><i>{$accomodation['title']}</i></td>
								</tr>
EOF;
						 if($bookings!=null){
							 $str .= '<tr><td>Active <em>bookings!</em></td></tr>';
						 	 foreach($bookings as $bk_index => $booking){
								 $str .= <<<EOF
								 <tr>
								 	<td>{$booking['username']} from {$booking['checkin_date']} to {$booking['checkout_date']}</td>
								 </tr>
EOF;
								}
						 }

						$str.='</table></td>';
						if($index%3==0)
							echo '</tr>';
						echo $str;
					}
					echo '</tr></table>';
				}else{ 	// No accomodations returned
					echo '<h2><i>You have no accomodations registered</i></h2>';
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
