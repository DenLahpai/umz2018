<?php 
require "functions.php";
 
?>
<html>
	<?php 
	$page_title = "Edit Booking";
	include "includes/head.html";
	?>
	<body>
		<!--content		-->
		<div class="content">
			<?php
			$header = "Edit Booking";
			include "includes/header.html";
			include "includes/main_menu.html";
			?>
			<main>
				<form id="theform" action="#" method="post">
					<ul>
						<li>
							Name: &nbsp;
						</li>	
					</ul>
				</form>
			</main>
		</div>
		<!--end of content-->
		<?php include "includes/footer.html"; ?>
	</body>
</html>