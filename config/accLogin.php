<?php
// 03/17/2022 Leny: Start working on login
// 04/04/2022 Keben: Login Sessions and Logout Work and got logout working
// 04/08/2022 Leny: Also get a logged in account's information (including landlord's properties)
// 04/24/2022 Leny: Got user ratings and their comments
// 04/27/2022 Keben: Fixed comment query

session_start();
require_once "../config/.config.php";

// User login
if (isset($_POST['login'])) {
    unset($_POST['login']);
    $db = getConnected();
    $Email = $_POST['email'];
    $Password = $_POST['psw'];
    $validation = $db->prepare("SELECT * FROM User WHERE Email= ?");
    $validation->bind_param('s', $Email);
    if ($validation->execute()) {
        $Account = $validation->get_result();
        $Acc = [];
        while ($row = $Account->fetch_assoc()) {
            $Acc[] = $row;
        }
        $noAccount = is_null($Acc);
        if ($noAccount) {
            $_SESSION["emailAttempt"] = $_POST['email'];
            $_SESSION["error"] = "Error: Email and/or password is incorrect!";
            header("Location: ../views/login.php");
        } else {
            // Get comments
            $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
            $Comments->bind_param('s', $Email);
            $Comments->execute();
            $GetComments = $Comments->get_result();
            $comments = [];
            while ($row = $GetComments->fetch_assoc()) {
                $comments[] = $row;
            }
            // Get likes/dislikes for each comment that has a rating
            $totalComments = count($comments);
            for ($i = 0; $i < $totalComments; $i++) {
                $commentIDs[] = $comments[$i]['CommentID'];
            }
            $cRatings = [];
            foreach ($commentIDs as $commentID) {
                $commentRatings = $db->prepare("SELECT * FROM CommentRates Where CommentID =?");
                $commentRatings->bind_param('i', $commentID);
                $commentRatings->execute();
                $commentRtes = $commentRatings->get_result();
                while ($row = $commentRtes->fetch_assoc()) {
                    $cRatings[] = $row;
                }
            }
            // Get account rating
            $getRating = $db->prepare("SELECT ForEmail, TotalRating 
            FROM User INNER JOIN
            (
                SELECT AVG(Stars) AS TotalRating, ForEmail
                FROM UserRates NATURAL JOIN User 
                GROUP BY ForEmail
                ) AS Ratings
                ON Ratings.ForEmail = User.Email
                WHERE User.Email = ?"
            );
            $getRating->bind_param('s', $Email);
            $getRating->execute();
            $Rating = $getRating->get_result();
            $accRating = $Rating->fetch_assoc();
            // Check if it is a tenant account, otherwise it will be a landlord account
            $accType = $db->prepare("SELECT Landlord.Email FROM Landlord Where Email =?");
            $accType->bind_param('s', $Email);
            if ($accType->execute()) {
                if (mysqli_stmt_bind_result($accType, $res_LEmail)) {
                    $landlordAcc = 0;

                    while ($accType->fetch()) {
                        $landlordAcc++;
                    }
                    if ($landlordAcc !== 0) {
                        $query = $db->prepare("SELECT * FROM Property NATURAL JOIN PropertyType
                            Where LEmail =?");
                        $query->bind_param('s', $res_LEmail);
                        $query->execute();
                        $properties = $query->get_result();

                        $propertyList = [];
                        while ($row = $properties->fetch_assoc()) {
                            $propertyList[] = $row;
                        }
                        $query = $db->prepare("SELECT Occupies.* FROM Property NATURAL JOIN Occupies WHERE Property.LEmail =?");
                        $query->bind_param('s', $res_LEmail);
                        $query->execute();
                        $myRenters = $query->get_result();

                        $myRentersList = [];
                        while ($row = $myRenters->fetch_assoc()) {
                            $myRentersList[] = $row;
                        };
                        echo json_encode($propertyList);
                        echo json_encode($myRentersList);
                    } else {
                        $query = $db->prepare("SELECT DISTINCT Property.*, PropertyType.Type, Occupies.Stars FROM Property 
                            NATURAL JOIN PropertyType NATURAL JOIN Occupies INNER JOIN Tenant ON Occupies.TEmail =?");
                        $query->bind_param('s', $Email);
                        $query->execute();
                        $properties = $query->get_result();

                        $propertyList = [];
                        while ($row = $properties->fetch_assoc()) {
                            $propertyList[] = $row;
                        }
                        $query = $db->prepare("SELECT Property.LEmail, PropertyType.Type, Occupies.* FROM Property 
                            NATURAL JOIN PropertyType NATURAL JOIN Occupies WHERE Occupies.TEmail =?");
                        $query->bind_param('s', $Email);
                        $query->execute();
                        $properties = $query->get_result();

                        $allRentals = [];
                        while ($row = $properties->fetch_assoc()) {
                            $allRentals[] = $row;
                        }
                    }
                }
                //Verify user with password
                $pass = password_verify($Password, $Acc[0]["Password"]);
                if ($pass) {
                    session_start();
                    if ($landlordAcc == 0) {
                        $_SESSION['loggedProfile'] = $Acc[0];
                        $_SESSION['previousRentals'] = $propertyList;
                        $_SESSION['allRentals'] = $allRentals;
                        $_SESSION['userComments'] = $comments;
                        $_SESSION['commentRatings'] = $cRatings;
                        $_SESSION['userRating'] = $accRating;
                        $_SESSION['Type'] = "Tenant";
                    } else {
                        $_SESSION['loggedProfile'] = $Acc[0];
                        $_SESSION['myProperties'] = $propertyList;
                        $_SESSION['myRenters'] = $myRentersList;
                        $_SESSION['userComments'] = $comments;
                        $_SESSION['commentRatings'] = $cRatings;
                        $_SESSION['userRating'] = $accRating;
                        $_SESSION['Type'] = "Landlord";
                    }
                    //Route to their profile pages
                    header("Location: ../views/myProfile.php");
                } else {
                    $_SESSION["emailAttempt"] = $_POST['email'];
                    $_SESSION["error"] = "Error: Email and/or password is incorrect!";
                    header("Location: ../views/login.php");
                }
            }
        }
    } else {
        echo "Error executing query: " . mysqli_error($db);
        die();
    }
}


if (isset($_POST['logout'])) {
    unset($_POST['logout']);
    session_start();
    session_destroy();
    header("Location: ../views/login.php");
}
