<?php /*last update: 11/2010 */ ?>

<?php
	require('protect.php');
	require('../../../../../../db_tt.php');
?>
<div id="sort1" class="rSortBy">
	<p class="opt">Ending in: 
		<select class="sortSelectDate" name="leaseMonth">
			<option value="none"></option>
			<option value="01">January</option>
			<option value="02">February</option>
			<option value="03">March</option>
			<option value="04">April</option>
			<option value="05">May</option>
			<option value="06">June</option>
			<option value="07">July</option>
			<option value="08">August</option>
			<option value="09">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
		</select>
		<select class="sortSelectDate" name="leaseYear">
			<option value="2010">2010</option>
		</select>
	</p>
	<p class="optData hidden"></p>
	<div class="clearfloat"></div>
</div><!-- #sort1 .rSortBy -->