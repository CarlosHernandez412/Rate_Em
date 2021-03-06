<?php
// 4-27-22 Leny: Allow tenant users to give a rating to previous rentals
// 4-28-22 Leny: Tenants can now give ratings to previous rented properties
// 4-30-22 Leny, Keben: Tested tenant Settings
session_start();
require_once "../config/.config.php";

// Update rating
if (isset($_POST['giveRating'])) {
    unset($_POST['giveRating']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PropertyID = $_POST['propertyID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $Stars = $_POST['rating'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    //Verify password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        if ($endDate === "Currently Renting!")
            $endDate = NULL;
        if (strlen($Stars) == 0) {
            $_SESSION["error"] = "Please give a rating!";
            header("Location: ../views/property.php");
        } else {
            $update = $db->prepare("CALL propertyRating(?, ?, ?, ?, ?)");
            $update->bind_param('sissi', $Email, $PropertyID, $startDate, $endDate, $Stars);
            if ($update->execute()) {
                // Get new updated rows information under the session
                $query = $db->prepare("SELECT Property.LEmail, PropertyType.Type, Occupies.* FROM Property 
                NATURAL JOIN PropertyType NATURAL JOIN Occupies WHERE Occupies.TEmail =?");
                $query->bind_param('s', $Email);
                if ($query->execute()) {
                    $properties = $query->get_result();
                    $allRentals = [];
                    while ($row = $properties->fetch_assoc()) {
                        $allRentals[] = $row;
                    }
                    $_SESSION['allRentals'] = $allRentals;
                    $_SESSION['success'] = 'Rating successfully updated!';
                    header("Location: ../views/rentals.php");
                } else {
                    echo "Error executing query: " . mysqli_error($db);
                    die();
                }
            } else {
                echo "Error executing query: " . mysqli_error($db);
                die();
            }
        }
    } else {
        $_SESSION["error"] = "Cannot give rating, password incorrect!";
        header("Location: ../views/rentals.php");
    }
}

?>