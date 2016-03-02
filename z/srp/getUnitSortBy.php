<?php /*last update: 11/2010 */ ?>

<?php
	require('protect.php');
	require('../../../../../../db_tt.php');
?>
<div id="sort1" class="rSortBy">
	<p class="opt">Filter By: 
		<select class="sortSelect" name="unitSelect">
			<option value="none"></option>
			<option value="yes">Occupied</option>
			<option value="no">Not Occupied</option>
		</select>
	</p>
	<p class="optData hidden"></p>
	<div class="clearfloat"></div>
</div><!-- #sort1 .rSortBy -->