<?php
session_start();
define("ROOT", "../");

require_once ROOT . 'db/Connection.php';
require_once ROOT . 'modules/functions.php';
$mysqli = getConnection();

$response = array();
$validate;

function createResponse($status, $message)
{
    return array('status' => $status, 'message' => $message);
}

//General Validation
do {
    if (isset($_POST)) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Invalid");
        break;
    }

    //Required fields validation
    if ($validate && !empty($_POST['email']) && !empty($_POST['password'])) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Required fields are empty");
        break;
    }

    //Email validation
    if ($validate && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Invalid email");
        break;
    }

    //Validate password length
    if (strlen($_POST['password']) > 7 && strlen($_POST['password']) < 17) {
        $validate = true;
    } else {
        $validate = false;
        $response = createResponse(0, "Password length should be between 8 to 16 characters");
        break;
    }
} while (0);

//Business Logic
if ($validate) {
    do {
        $_POST = safeStringForSQL($_POST);
        $password = hash("sha256", $_POST['password']);

        $sql = "SELECT RegCode, RegName, RegEmail, RegPassword, RegMobile, FamilyCode, ForgotFlag FROM Table109 WHERE RegEmail = '" . $_POST['email'] . "' AND RegPassword = '" .$password ."' AND ActiveFlag = 1 LIMIT 1";

        if ($result = $mysqli->query($sql)) {
            if ($result->num_rows == 0) {
                $response = createResponse(0, "Invalid email or password");
                break;
            } else {
                $row = $result->fetch_assoc();
                session_regenerate_id();
                $_SESSION['email'] = $row['RegEmail'];
                $_SESSION['name'] = $row['RegName'];
                $_SESSION['s_id'] = $row['RegCode'];
                $_SESSION['mobile'] = $row['RegMobile'];
                $_SESSION['familyCode'] = $row['FamilyCode'];

                $today = new DateTime("now");

                $sql = "UPDATE `Table109` SET `RegHitsNo`= `RegHitsNo` + 1, `LastLoginDateTime`= '" . $today->format("Y-m-d H:i:s") . "'  WHERE `RegCode` = " . $row['RegCode'];
                //echo $sql;
                $mysqli->query($sql);

                if (intval($row['ForgotFlag']) == 2) {
                    $response = createResponse(2, "Login Successfull");
                } else {
                    $response = createResponse(1, "Login Successfull");
                }

            }
        }

    } while (0);
}

echo json_encode($response);
$mysqli->close();
?>