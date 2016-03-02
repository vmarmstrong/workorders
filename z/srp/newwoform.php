<?php /*last update: 11/2010 */ ?>

<h2>New Workorder</h2>
<p><?=$formstatus?></p>
<form name="newwoform" action="newwo.php" method="post" class="newwo">
<div id="wo">
	<div class="left">
		<div class="ques">
			<p class="l"><label for="unit">Unit</label></p>
			<p class="i"><input type="text" name="unitnumber" id="unitnumber" /></p>
			<p class="e"><?=$unitnumberErr?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	</div><!-- .left -->
	<div class="right">
		<div class="ques">
			<p class="l"><label for="by">Requested By</label></p>
			<p class="i">
				<select name="by" id="by">
				<option value="none"> </option>
					<?php
						$res_sql="SELECT u.id,u.unit,l.id,lr.resident_id,r.fName,r.lName FROM unit AS u JOIN lease AS l ON(l.unit_id=u.id) JOIN lease_resident as lr ON (lr.lease_id=l.id) JOIN resident AS r ON(r.id=lr.resident_id) WHERE u.unit='24' ORDER BY r.fName";
						$res_result=mysql_query($res_sql);
						echo "<optgroup label=\"Residents\">";
						while($row=mysql_fetch_assoc($res_result)){
							$res_unit_id=$row['id'];
							$res_id=$row['resident_id'];
							$res_name=$row['fName']." ".$row['lName'];
							$res_email=$row['email'];
							echo "<option value=\"R".$res_id."\">".$res_name."</option>";
						}
						echo "</optgroup>";
						echo "<optgroup label=\"Staff\">";
							$emp_sql="SELECT id,fName,lName FROM `employee` WHERE NOT level='vendor' ORDER BY fName";
							$emp_result=mysql_query($emp_sql);
							while($row=mysql_fetch_assoc($emp_result)){
								$emp_id=$row['id'];
								$emp_name=$row['fName']." ".$row['lName'];
								$emp_title=$row['title'];
								$emp_level=$row['level'];
								echo "<option value=\"E".$emp_id."\">".$emp_name."</option>";
								}
						echo "</optgroup>";
					?>
				</select>
			</p>
			<p class="e"></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques checks">
			<p id="notify"><label for="sendemail">Send Email Notification</label> <input type="checkbox" name="sendemail" id="sendemail" /></span>
			<p class="e"></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques checks">
			<p id="enter"><label for="enter"> Permission To Enter</label> <input type="checkbox" name="enter" id="enter" /></span>
			<p class="e"></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	</div><!-- .right -->
</div><!-- #wo -->
<div class="clearfloat"></div>
<fieldset class="request">
	<legend>Request #1</legend>
	<div class="left">
		<div class="ques">
			<p class="l"><label for="wocat">Category</label></p>
			<p class="i">
				<select name="wocat" id="wocat">
					<?php
						$cats_sql="SELECT id,type FROM cats ORDER BY type";
						$cats_result=mysql_query($cats_sql);
						while($row=mysql_fetch_assoc($cats_result)){
							$cat_id=$row['id'];
							$cat_type=$row['type'];
							if($cat_id==1){
								echo "<option value=\"".$cat_id."\" selected=\"selected\" >".$cat_type."</option>";
							}else{
								echo "<option value=\"".$cat_id."\">".$cat_type."</option>";
							}
						}
					?>
				</select>
			</p>
			<p class="e"></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label for="wostatus">Status</label></p>
			<p class="i">
				<select name="wostatus" id="wostatus">
					<?php
						$stats_sql="SELECT id,type FROM status ORDER BY type";
						$stats_result=mysql_query($stats_sql);
						while($row=mysql_fetch_assoc($stats_result)){
							$stats_id=$row['id'];
							$stats_type=$row['type'];
							if($stats_id==1){
								echo "<option value=\"".$stats_id."\" selected=\"selected\" >".$stats_type."</option>";
							}else{
								echo "<option value=\"".$stats_id."\">".$stats_type."</option>";
							}
						}
					?>
				</select>
			</p>
			<p class="e"></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label for="wotech">Service Tech</label></p>
			<p class="i">
				<select name="wotech" id="wotech">
					<?php
						$emp_sql="SELECT id,fName,lName,title,level FROM `employee` WHERE level='service' OR level='vendor' ORDER BY fName";
						$emp_result=mysql_query($emp_sql);
						while($row=mysql_fetch_assoc($emp_result)){
							$emp_id=$row['id'];
							$emp_name=$row['fName']." ".$row['lName'];
							$emp_title=$row['title'];
							$emp_level=$row['level'];
							if($emp_title=="Occupied"){
								echo "<option value=\"".$emp_id."\" selected=\"selected\" >".$emp_name."</option>";
							}else{
								echo "<option value=\"".$emp_id."\">".$emp_name."</option>";
							}	
						}
					?>
				</select>
			</p>
			<p class="e"></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	</div><!-- .left -->
	<div class="right">
		<div class="ques">
			<p class="l"><label for="details">Detailed Request (displayed in resident email)</label></p>
			<p class="i"><textarea cols="40" rows="4" name="details" id="details"></textarea></p>
			<p class="e"><?=$detailsErr?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label for="onotes">Office Notes</label></p>
			<p class="i"><textarea cols="40" rows="4" name="onotes" id="onotes"></textarea></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	</div><!-- .right -->
	<div class="clearfloat"></div>
</fieldset>
	<!-- <p class="addone"><a href="">+ Add another request</a></p> -->
	<p><input class="submitbtn" type="submit" name="submit" value="Submit" /> <span class="secondlink"><a href="index.php">Cancel</a></span></p>
</form>