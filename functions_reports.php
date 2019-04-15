<?php
require_once "functions.php";

//function to generate reports for bookings
function reports_bookings ($job, $var1, $var2) {
    $database = new Database();

    $AgentId = $_REQUEST['AgentId'];
    $StatusId = $_REQUEST['StatusId'];
    $Guide_RequestId = $_REQUEST['Guide_RequestId'];
    $Tour_guideId = $_REQUEST['Tour_GuideId'];
    $Arrival_Date1 = $_REQUEST['Arrival_Date1'];
    $Arrival_Date2 = $_REQUEST['Arrival_Date2'];

    if (empty($Arrival_Date2)) {
        $Arrival_Date2 = $Arrival_Date1;
    }

    $query = "SELECT
        bookings.Reference,
        bookings.Name,
        bookings.Pax,
        agents.Name,
        guide_requests.Request,
        tour_guides.Name,
        bookings.Arrival_Date,
        booking_statuses.Status
        FROM bookings
        LEFT OUTER JOIN agents
        ON bookings.AgentId = agents.Id
        LEFT OUTER JOIN guide_requests
        ON bookings.Guide_RequestId = guide_requests.Id
        LEFT OUTER JOIN tour_guides
        ON bookings.Tour_GuideId = tour_guides.Id
        LEFT OUTER JOIN booking_statuses
        ON bookings.StatusId = booking_statuses.Id
    ";

    //$c = 00000;
    if ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        $query .= ";";
        $database->query($query);
    }

    //$c = 00001;
    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        $query .= "WHERE bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
        echo $query;
    }

    //$c = 00010;
    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        $query .= "WHERE bookings.Tour_GuideId = :Tour_GuideId ;";
        $database->query($query);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        echo $query;
    }

    //$c = 00100;
    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        $query .= "WHERE bookings.Guide_RequestId = :Guide_RequestId ;";
        $database->query($query);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        echo $query;
    }

    //$c = 01000;
    elseif ($AgentId == NULL && $StatusId != NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        $query .= " WHERE bookings.StatusId = :StatusId ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
    }

    //$c = 10000;
    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        $query .= " WHERE bookings.AgentId = :AgentId ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
    }

    //$c = 00011;
    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 != NULL) {
        $query .= " WHERE bookings.Tour_GuideId = :Tour_GuideId
            AND Arrival_Date >= :Arrival_Date1
            AND Arrvial_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }
}

?>
