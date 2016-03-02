<?php /*last update: 11/2010 */ ?>

<div id="bgtop">
	<div id="header">
		<div id="logo"><h1><a href="index.php">timelyTask</a></h1></div>
		<div id="search">
			<form name="searchform" action="srp/search.php" method="post">
				<p>Search for 
					<input type="text" name="key" id="key"> 
					in 
					<select name="page" id="page">
						<option value="w">Workorders</option>
						<option value="u">Units</option>
						<option value="r">Residents</option>
						<option value="v">Vehicles</option>
					</select> 
					<input type="submit" name="search" value="Go" id="searchbtn" />
				</p>
			</form>
		</div>
		<div id="acct">
			<h3>MyHome Apartments</h3>
			<h4><?=$_SESSION['fName']?> <?=$_SESSION['lName']?></h4>
			<p><?php if($_SESSION['level']=="admin"){?><a href="account.php">My Account</a> |<?php } ?> <a href="user.php?id=<?=$_SESSION['id']?>">My Profile</a> | <a href="srp/logout.php">Logout</a></p>
		</div>
	</div><!-- #header -->
	<div class="clearfloat"></div>
</div><!-- #bgtop -->