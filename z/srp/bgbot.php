<?php /*last update: 11/2010 */ ?>

<div id="bgbot">
	<div id="footer">
		<div id="copyright">&#169 2010 <a href="http://vmcnichol.com">vmarmstrong.com</a> | <a href="../contact.php">Contact Us</a></div><!-- #copyright -->
		<div id="acctlink">
			<p>
				<?php if($_SESSION['level']=="admin"){?><a href="account.php">My Account</a> | <?php } ?>
				<a href="user.php?id=<?=$_SESSION['id']?>" title="Profile">profile</a> | 
				<a href="srp/logout.php" title="Logout">logout</a>
			</p>
		</div><!-- #acctlink -->
	</div><!-- #footer -->
</div><!-- #bgbot -->