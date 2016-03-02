<?php /*last update: 11/2010 */ ?>

<?php
require('protect.php');
require('../../../../../../db_tt.php');
?>
<div id="sort1" class="rSortBy">
	<p class="opt">Filter By: 
		<select class="sortSelect" name="woSelect" id="woSelect">
			<option value="none"></option>
			<option value="date">Date</option>
			<option value="unit">Unit</option>
			<option value="status">Status</option>
		</select>
	</p>
	<p class="optData hidden"></p>
	<div class="clearfloat"></div>
</div><!-- #sort1 .rSortBy -->