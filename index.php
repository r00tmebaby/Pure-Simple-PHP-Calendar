<?php
session_start();

$_SESSION['month'] 	= isset($_GET['month'])? (int)$_GET['month']: (int)date('m');
$_SESSION['year'] 	= isset($_GET['year'])? (int)$_GET['year']: (int) date('Y');
$months 		= array (1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
$week 			= array ('Mon','Tue','Wed','Thu','Fri','Sat','Sun');

if($_SESSION['month'] > 12){
	$_SESSION['year'] 	= $_GET['year'] +1;
	$_SESSION['month'] 	= 1;
}
elseif($_SESSION['month'] < 1 || $_SESSION['year'] > 2050 || $_SESSION['year'] < 0){
	$_SESSION['month'] 	= (int)date('m');
	$_SESSION['year'] 	= (int) date('Y');
}

?>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="calendar">
		<h2>Event calendar</h2>
		<div class="nav">
			<a class="prev" href="?&month=<?php echo $_SESSION['month'] -1?>&year=<?php echo $_SESSION['year']?> "> &#60;</a>
				<?php echo $months[$_SESSION['month']] ." ". $_SESSION['year'] ?>
			<a class="next" href="?&month=<?php echo $_SESSION['month'] +1?>&year=<?php echo $_SESSION['year']?> "> &#62; </a>						
		</div>
		<table width="400px">
			<tr>
				<thead>
					<?php
						foreach($week as $count => $dayOfWeek){
							echo '<th class="col-'.$count.'">'.$dayOfWeek.'</th>';
						}						
					?>
				</thead>
			</tr>
			<?php					
					
				#Event--Test--Example------------
				$event_content = '								
				
					<h4>Omnis iste natus error sit voluptatem dolor</h4>
					<p class="info-line"><span class="time">10:30 AM</span><span class="place">Lincoln High School</span></p>
					<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident similique.</p>
				';			
								#day, month, year   event info
				$event_test = array(24,  5,     2020, $event_content);
				#-------------------------------
	
				$daysInCurrentMonth 	= cal_days_in_month(CAL_GREGORIAN, $_SESSION['month'], $_SESSION['year']);	
				$firstDayOfWeek 	= jddayofweek(gregoriantojd($_SESSION['month'],1,$_SESSION['year']),1);
				$tdOffset 		= date("w", strtotime($firstDayOfWeek));
				$days 			= 0;
				
				for($i=0;$i < 35; $i++){								
					while($tdOffset > 1){
						echo '<td class="col-2" style="border:none"><div></div>';
						$tdOffset--;
						$i++;
					}
					if($i % 7 == 0) echo "</tr><tr>";
					if($days < $daysInCurrentMonth){
						$days++;
						if($event_test[0] == $days && $event_test[1] == $_SESSION['month']&& $event_test[2] == $_SESSION['year']){
							echo '<td class="event"><div class="tooltip">' .$days .'<span class="tooltiptext">'.$event_test[3].'</span></div></td>';
						}
						else{
							echo '<td style="background:#dfffbf;">' .$days. '</td>';	
						}						  	
					}						
				}
			?>
		</table>
	</div>
</body>

