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
	<link href="css/rating-widget.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/rating-widget.js"></script>
	<title>History</title>
</head>
<body>
  <?php include('navigation.php');?>
	<?php include('navigation_profile.php'); ?>
	<div class="profile_content">
		<div id="history_profile_section">
			<?php
				$Acc = new Accommodation();
				$data = $Acc->getBookingHistoryByUserId($_SESSION['user_id']);
				if($data != null){
					echo '<h1>My Accommodation History</h1>';
					echo '<table><tr>';
					foreach($data as $index=> $accomodation){
						if($index%3	==0)
							echo '<tr>';
						$checkin  = date('d/F/Y',strtotime($accomodation['checkin_date']));
						$checkout = date('d/F/Y',strtotime($accomodation['checkout_date']));
						$str = <<<EOF
						<td>
							<table>
								<tr>
									<td width='50%'><a href="accommodation.php?id={$accomodation['accom_id']}"><img src="{$accomodation['path_to_image']} "alt="Avatar" width="350" height="350"></td>
								</tr>
								<tr>
									<td align="center"><i>{$accomodation['title']}</i></td
								</tr>
								<tr>
									<td align="center">
										<small>(<b>from</b> {$checkin} <b>to</b> {$checkout})</small>
									</td>
								</tr>
								<tr>
									<td>
									<form action="rate.php" method="POST" class="rating-widget">
										<label>Rate this Accommodation :</br>
										<input type="range" min="0" max="5" value="{$accomodation['rating']}" name="rating" required/>
										</label></br>
										<label> Leave a comment</br>
										<textarea rows=7 cols=43 type="text" name="comment"></textarea>
										<input type="hidden" name="rent" value="{$accomodation['rent_id']}">
										</br>
										<button type="submit" name="submit">Submit</button>
									</form>
									</td>
								</tr>
							</table>
						</td>
EOF;
							if($index%3==0)
								echo '</tr>';
							echo $str;
						}
						echo '</tr></table>';
					}else{ 	// No accomodations returned
						echo '<h2><i>You have visited no Accommodations</i></h2>';
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
