<?php
require "functions.php";

// getting bookingsId
$bookingsId = trim($_REQUEST['bookingsId']);

//getting data from the table bookings
$rows_bookings = table_bookings('select', $bookingsId);
foreach ($rows_bookings as $row_bookings) {
    // code...
}

// updating the table bookings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$Name = trim($_REQUEST['Name']);
	if ($Name == $row_bookings->bookingsName) {
		table_bookings('update', $bookingsId);
	}
	else {
		$rowCount = table_bookings('check', NULL);
		if ($rowCount == 0) {
			table_bookings('update', $bookingsId);
		}
		else {
			$error_message = "Duplicate Entry!";
		}
	}
}
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
						<li class=\"notice error\">
							<?php
							if (!empty($error_message)) {
								echo $error_message;
							}
							?>
						</li>
						<li>
							Reference: &nbsp;
							<input type="text" name="Reference" id="Reference" value="<?php echo $row_bookings->Reference; ?>" required>
						</li>
						<li>
							Name: &nbsp;
							<input type="text" name="Name" id="Name" value="<?php echo $row_bookings->bookingsName;?>" required>
						</li>
                        <li>
                            Pax: &nbsp;
                            <input type="number" name="Pax" id="Pax" value="<?php echo $row_bookings->bookingsPax; ?>" min="1" max="999">
                        </li>
                        <li>
                            Agent: &nbsp;
                            <select id="AgentId" name="AgentId">
                                <?php
                                $rows_agents = table_agents('select', NULL);
                                foreach ($rows_agents as $row_agents) {
                                    if ($row_bookings->AgentId == $row_agents->Id) {
                                    	echo "<option value=\"$row_agents->Id\" selected>".
                                    	$row_agents->Name."</option>";
                                    }
                                    else {
                                    	echo "<option value=\"$row_agents->Id\">".
                                    	$row_agents->Name."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                        	Guide Request: &nbsp;
                        	<select id="Guide_RequestId" name="Guide_RequestId">
								<?php
								$rows_guide_requests = table_guide_requests('select', NULL);
                        		foreach ($rows_guide_requests as $row_guide_requests) {
                        			if ($row_guide_requests->Id == $row_bookings->Guide_RequestId) {
                        				echo "<option value=\"$row_guide_requests->Id\" selected>".$row_guide_requests->Request."</option>";
                        			}
                        			else {
                        				echo "<option value=\"$row_guide_requests->Id\">".$row_guide_requests->Request."</option>";
                        			}
                        		}
                        		?>

                        	</select>
                        </li>
						<li>
							Guide: &nbsp;
							<select id="Tour_GuideId" name="Tour_GuideId">
								<?php
								$rows_tour_guides = table_tour_guides('select', NULL);
								foreach ($rows_tour_guides as $row_tour_guides) {
									if ($row_tour_guides->Id == $row_bookings->Tour_GuideId) {
										echo "<option value=\"$row_tour_guides->Id\" id=\"guideOption$row_tour_guides->Id\" selected>".$row_tour_guides->Name."</option>";
									}
									else {
										echo "<option value=\"$row_tour_guides->Id\" id=\"guideOption$row_tour_guides->Id\">".$row_tour_guides->Name."</option>";
									}
								}
								?>
								<option value="0" class="highlight red">No Guide</option>
							</select>
							<button type="button" class="button search" id="modalOpen" name="button">Search Guide</button>
						</li>
                        <li>
                        	Arrival Date: &nbsp;
                        	<input type="date" name="Arrival_Date" id="Arrival_Date" value="<?php echo $row_bookings->Arrival_Date; ?>">
                        </li>
						<li>
							Remark: &nbsp;
							<input type="text" name="Remark" id="Remark" value="<?php echo $row_bookings->Remark; ?>">
						</li>
						<li>
							Status: &nbsp;
							<select id="StatusId" name="StatusId">
								<?php
								$rows_booking_statuses = table_booking_statuses('select', NULL);
								foreach ($rows_booking_statuses as $row_booking_statuses) {
									if ($row_booking_statuses->Id == $row_bookings->StatusId) {
										echo "<option value=\"$row_booking_statuses->Id\" selected>".$row_booking_statuses->Status."</option>";
									}
									else {
										echo "<option value=\"$row_booking_statuses->Id\">".$row_booking_statuses->Status."</option>";
									}
								}
								?>
							</select>
						</li>
						<li>
                            <button type="button" class="button medium" name="buttonSubmit" id="buttonSubmit" onclick="check2Fields('AgentId', 'Guide_RequestId');">Update</button>
                        </li>
					</ul>
				</form>
			</main>
		</div>
		<!--end of content-->
		<?php
		include "includes/modal-guide_select.php";
		include "includes/footer.html";
		?>
	</body>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript" src="js/modal.js"></script>
</html>
