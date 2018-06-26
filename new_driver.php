<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$rowCount = table_drivers('check', NULL);
	if ($rowCount == 0) {
		table_drivers('insert', NULL);
	}
	else {
		$error_message = "Duplicate Entry!";
	}
}
?>
<!DOCTYPE html>
<html>
	<?php
	$page_title = "New Driver";
	include "includes/head.html";
	?>
	<body>
		<!-- content -->
		<div class="content">
			<?php
			$header = "New Driver";
			include "includes/header.html";
			include "includes/main_menu.html";
			?>
			<main>
				<form id="theform" action="#" method="post">
					<ul>
						<li>
							<?php
							if (!empty($error_message)) {
								echo $error_message;
							}
							?>
						</li>
						<li>
							Title: &nbsp;
							<select id="Title" name="Title">
								<?php select_titles(NULL); ?>
							</select>
						</li>
						<li>
							Name: &nbsp;
							<input type="text" name="Name" id="Name" placeholder="Name" required>
						</li>
						<li>
							Mobile: &nbsp;
							<input type="text" name="Mobile" id="Mobile" placeholder="Mobile Number" required>
						</li>
						<li>
							License: &nbsp;
							<input type="text" name="License" id="License" placeholder="License" required>
						</li>
						<li>
							Class: &nbsp;
							<input type="text" name="Class" id="Class" placeholder="License Class">
						</li>
						<li>
							Supplier: &nbsp;
							<select Id="SupplierId" name="SupplierId">
								<option value="">Select</option>
								<?php
								$rows_suppliers = table_suppliers('select', NULL);
								foreach ($rows_suppliers as $row_suppliers) {
									echo "<option value=\"$row_suppliers->Id\">".$row_suppliers->Name."</option>";
								}
								?>
							</select>
						</li>
						<li>
							<button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Title', 'SupplierId');">Submit</button>
						</li>
					</ul>
				</form>
			</main>
		</div>
		<!-- end of content -->
		<?php include "includes/footer.html"; ?>
	</body>
	<script type="text/javascript" src="js/scripts.js"></script>
</html>
