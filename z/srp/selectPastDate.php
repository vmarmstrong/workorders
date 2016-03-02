<?php /*last update: 11/2010 */ ?>

<?php
	$year=date('Y',time());
?>


<select name="month" class="date">
	<?php
		$marr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		$m=0;
		while($m <= 12){
			$m++;
			if($m<10){
				$mv='0' + $m;
			}else{
				$mv=$m;
			}
			$m--;
			echo "<option value=\"$mv\">$marr[$m]</option>";
			$m++;
		}
	?>
</select> <select name="day" class="date">
	<?php
		$d=1;
		while($d <= 31){
			if($d<10){
				$dv='0' + $d;
			}else{
				$dv=$d;
			}
			echo "<option value=\"$dv\">$d</option>";
			$d++;
		}
	?>
</select> <select name="year" class="date">
	<?php
		$i=0;
		while($i <= 100){
			$cy=$year-$i;
			echo "<option value=\"$cy\">$cy</option>";
			$i++;
		}
	?>
</select>