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

    if ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        //$c = 00000;
        $query .= " ;";
        $database->query($query);
    }

    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        //$c = 00001;
        $query .= "WHERE bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        //$c = 00010;
        $query .= "WHERE bookings.Tour_GuideId = :Tour_GuideId ;";
        $database->query($query);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
    }

    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        //$c = 00100;
        $query .= "WHERE bookings.Guide_RequestId = :Guide_RequestId ;";
        $database->query($query);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
    }

    elseif ($AgentId == NULL && $StatusId != NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        //$c = 01000;
        $query .= " WHERE bookings.StatusId = :StatusId ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        //$c = 10000;
        $query .= " WHERE bookings.AgentId = :AgentId ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
    }

    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 != NULL) {
        //$c = 00011;
        $query .= " WHERE bookings.Tour_GuideId = :Tour_GuideId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrvial_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        //$c = 00101;
        $query .= " WHERE bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrvial_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        //$c = 00110;
        $query .= " WHERE Guide_RequestId = :Guide_RequestId
            AND Tour_GuideId = :Tour_GuideId
        ;";
        $database->query($query);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
    }

    elseif ($AgentId == NULL && $StatusId != NULL && $Gudie_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        //$c = 01001;
        $query .= " WHERE bookings.StatusId = :StatusId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrvial_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId == NULL && $StatusId != NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        //$c = 01010;
        $query .= " WHERE bookings.StatusId = :StatusId
            AND bookings.Tour_GuideId = :Tour_GuideId
        ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
    }

    elseif ($AgentId == NULL && $StatusId != NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        // $c = 01100;
        $query .= " WHERE bookings.StatusId = :StatusId
            AND bookings.Guide_RequestId = :Guide_RequestId
        ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
    }

    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        //$c = 10001;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        //$c = 10010;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.Tour_GuideId = :Tour_GuideId
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
    }

    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        //$c = 10100;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.Guide_RequestId = :Guide_RequestId
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
    }

    elseif ($AgentId != NULL && $StatusId != NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        //$c = 11000;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.StatusId = :StatusId
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':StatusId', $StatusId);
    }

    elseif ($AgentId == NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId != NULL && $Arrival_Date1 != NULL) {
        //$c = 00111;
        $query .= " WHERE bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Tour_GuideId = :Tour_GuideId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrvial_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId == NULL && $StatusId != NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 != NULL) {
        //$c = 01011;
        $query .= " WHERE bookings.StatusId = :StatusId
            AND bookings.Tour_GuideId = :Tour_GuideId
            AND bookings.Arrival_Date >= :Arrvial_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId == NULL && $StatusId != NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        //$c = 01101;
        $query .= " WHERE bookings.StatusId = :StatusId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId == NULL && $StatusId != NULL && $Guide_RequestId != NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        // $c = 01110;
        $query .= " WHERE bookings.StatusId = :StatusId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Tour_GuideId = :Tour_GuideId
        ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
    }

    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 != NULL) {
        //$c = 10011;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.Tour_GuideId = :Tour_GuideId
            AND bookings.Arrival_Date >= :Arrvial_Date1
            AND bookings.Arrvial_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrival_Date1', $Arrvial_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }
    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        // $c = 10101;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Arrival_Date = :Arrival_Date1
            AND booking.Arrival_Date = :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Arrival_Date1', $Arrvial_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        // $c = 10110;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Tour_GuideId = :Tour_GuideId
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
    }

    elseif ($AgentId != NULL && $StatusId != NULL && $Guide_RequestId == NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        //$c = 11001;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.StatusId = :StatusId
            AND bookings.Arrival_Date = :Arrvial_Date1
            AND bookings.Arrival_Date = :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Arrvial_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId != NULL && $StatusId != NULL && $Guide_RequestId == NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        // $c = 11010;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.StatusId = :StatusId
            AND bookings.Tour_GuideId = :Tour_GuideId
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
    }

    elseif ($AgentId != NULL && $StatusId != NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 == NULL) {
        // $c = 11100;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.StatusId = :StatusId
            AND bookings.Guide_RequestId = :Guide_RequestId
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
    }

    elseif ($AgentId == NULL && $StatusId != NULL && $Guide_RequestId != NULL && $Tour_GuideId != NULL && $Arrival_Date1 != NULL) {
        //$c = 01111;
        $query .= " WHERE bookings.StatusId = :StatusId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Tour_GuideId = :Tour_GuideId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId != NULL && $StatusId == NULL && $Guide_RequestId != NULL && $Tour_GuideId != && $Arrival_Date1 != NULL) {
        // $c = 10111;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Tour_GuideId = :Tour_GuideId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId != NULL && $StatusId != NULL && $Guide_RequestId == NULL && $Tour_GuideId != $Arrival_Date1 != NULL) {
        // $c = 11011;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.StatusId = :StatusId
            AND bookings.Tour_GuideId = :Tour_GuideId
            AND bookings.Arrival_Date = :Arrival_Date1
            AND bookings.Arrival_Date = :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId != NULL && $StatusId != NULL && $Guide_RequestId != NULL && $Tour_GuideId == NULL && $Arrival_Date1 != NULL) {
        // $c = 11101;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.StatusId = :StatusId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }

    elseif ($AgentId != NULL && $StatusId != NULL && $Guide_RequestId != NULL && $Tour_GuideId != NULL && $Arrival_Date1 == NULL) {
        //$c = 11110;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.StatusId = :StatusId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Tour_GuideId = :Tour_GuideId
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
    }
    elseif ($AgentId != NULL && $StatusId != NULL && $Gudie_RequestId != NULL && Tour_GuideId != NULL && $Arrival_Date1 != NULL) {
        //$c = 11111;
        $query .= " WHERE bookings.AgentId = :AgentId
            AND bookings.StatusId = :StatusId
            AND bookings.Guide_RequestId = :Guide_RequestId
            AND bookings.Tour_GuideId = :Tour_GuideId
            AND bookings.Arrival_Date >= :Arrival_Date1
            AND bookings.Arrival_Date <= :Arrival_Date2
        ;";
        $database->query($query);
        $database->bind(':AgentId', $AgentId);
        $database->bind(':StatusId', $StatusId);
        $database->bind(':Guide_RequestId', $Guide_RequestId);
        $database->bind(':Tour_GuideId', $Tour_GuideId);
        $database->bind(':Arrival_Date1', $Arrival_Date1);
        $database->bind(':Arrival_Date2', $Arrival_Date2);
    }
    else {
        //Code...
    }
}
?>
