<?php
require "functions.php";

//Only departments id 1 and 2 has access to this page.
if ($d > 2) {
    header("location: no_access.php");
}

//getting the Id
$vehiclesId = trim($_REQUEST['vehiclesId']);
if (!is_numeric ($vehiclesId)) {
	echo "There was a problem! Please go back and try again.";
	die();
}

// getting the data to be edited from the table vehicles
$rows_vehicles = table_vehicles('select_one', $vehiclesId, NULL);
foreach ($rows_vehicles as $row_vehicles) {
	# code...
}

//updating the table vehicles when the button update is pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$rowCount = table_vehicles ('check_before_update', $vehiclesId, NULL);
	if ($rowCount == 0) {
		table_vehicles ('update', $vehiclesId, NULL);
	}
	else {
		$error_message = "Duplicate Entry!";
	}
}
?>
<!DOCTYPE html>
<html>
	<?php
	$page_title = "Edit Vehicle";
	include "includes/head.html";
	?>
	<body>
		<!-- content -->
		<div class="content">
			<?php
			$header = "Edit Vehicle";
			include "includes/header.html";
			include "includes/main_menu.html";
			?>
			<main>
				<form id="theform" action="#" method="post">
					<ul>
						<li>
							<?php if (!empty($error_message)) {
								echo $error_message;
							}
							?>
						</li>
						<li>
							 License: &nbsp;
							 <input type="text" name="License" id="License" value="<?php echo $row_vehicles->License; ?>" required>
						</li>
						<li>
							Type: &nbsp;
							<input type="text" name="Type" id="Type" value="<?php echo $row_vehicles->Type; ?>" required>
						</li>
                        <li>
                            Seats: &nbsp;
                            <input type="text" name="Seats" id="Seats" value="<?php echo $row_vehicles->Seats; ?>" min="2" max="99">
                        </li>
                        <li>
                            Supplier: &nbsp;
                            <select id="SupplierId" name="SupplierId">
                                <?php
                                $rows_suppliers = table_suppliers('select_all', NULL, NULL);
                                foreach ($rows_suppliers as $row_suppliers) {
                                    if ($row_suppliers->Id == $row_vehicles->SupplierId) {
                                        echo "<option value=\"$row_suppliers->Id\" selected>".$row_suppliers->Name."</option>";
                                    }
                                    else {
                                        echo "<option value=\"$row_suppliers->Id\">".$row_suppliers->Name."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('Type', 'SupplierId')">Update</button>
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
