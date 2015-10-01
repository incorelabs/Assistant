<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 30/09/15
 * Time: 5:36 PM
 */
define("ROOT", "");

require_once ROOT . 'db/Connection.php';
require_once ROOT . 'modules/functions.php';
require_once ROOT . "mail/MailerAutoload.php";

$mysqli = getConnection();
$response = array();
$validate = true;

function createResponse($status, $message)
{
    return array('status' => $status, 'message' => $message);
}

do{
    if(empty($_GET['email']) && empty($_GET['hash'])){
        $validate = false;
        $response = createResponse(0,"Invalid approach, please use the link that has been sent to your email.");
    }
}while(0);

if($validate){
    $email = $mysqli->escape_string($_GET['email']);
    $hash = $mysqli->escape_string($_GET['hash']);

    $sql = "SELECT RegEmail, Hash, ActiveFlag FROM Table109 WHERE RegEmail = '".$email."' AND Hash = '".$hash."' AND ActiveFlag = 0";

    if($result = $mysqli->query($sql)){
        if($result->num_rows > 0){
            $sql = "UPDATE Table109 SET ActiveFlag = 1 WHERE RegEmail = '".$email."' AND Hash = '".$hash."' AND ActiveFlag = 0;UPDATE Table107 SET ActiveFlag = 1 WHERE Email = '".$email."' AND ActiveFlag = 0";

            $mysqli->multi_query($sql) or die($mysqli->error);
            $validate = true;
            $response = createResponse(1,"Your account has been activated, you can now Sign In.");
        }
        else{
            $validate = false;
            $response = createResponse(0,"This url is either invalid or you have already activated your account.");
        }
    }
}

//echo $response["message"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assistant - Verify</title>
    <?php
    include_once ROOT . 'dist/fetchCSS.php';
    ?>
    <link rel="stylesheet" href="dist/homePage/css/style.css"/>
</head>
<body>
<?php
include_once ROOT . 'dist/navbar_logout.php';
$root_location = ROOT;
echo $navbar_str;
?>
<div class="container">
    <div class="well-top-margin">
        <?php
                if($response["status"] == 1)
                {
        ?>
                <div class="alert alert-success" id="alertDiv">
                    <div class="text-left">

                        <strong>
                            <p>Great!</p>
                        </strong>
                        <p>
                            <?php
                            echo $response["message"];
                            ?>
                        </p>
                    </div>
                    <div>
                        <a href="login.php"><button type="button" class="btn btn-success">Sign In</button></a>
                    </div>
                </div>
        <?php
                }

                else
                {
        ?>
                <div class="alert alert-warning" id="alertDiv">
                    <div class="text-left">

                        <strong>
                            <p>Oh snap! You got an error!</p>
                        </strong>
                        <p>
                            <?php
                            echo $response["message"];
                            ?>
                        </p>
                    </div>
                    <div>
                        <a href="register.php"><button type="button" class="btn btn-warning">Sign Up</button></a>
                    </div>
                </div>
        <?php
                }
        ?>
    </div>
</body>
</html>
