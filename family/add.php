<?php
session_start();
define("ROOT", "../");

include_once ROOT.'dist/authenticate.php';


$familyCode = 0;
$response = array();

if (isset($_POST)) {
	if (!empty($_POST["name"]) && !empty($_POST["relation"]) && !empty($_POST['dob']) && !empty($_POST['email']) && !empty($_POST['gender'])) {
		if (preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) {
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$dob = explode("/", $_POST['dob']);
				$dob = array($dob[2],$dob[1],$dob[0]);
				if (strlen($dob[0]) == 4 && $dob[1] < 13 && $dob[2] < 32) {
					$_POST['dob'] = implode("-", $dob);


					require_once ROOT.'db/Connection.php';
					require_once ROOT.'modules/functions.php';
					$mysqli = getConnection();

					$sql = "SELECT RegEmail FROM Table109 WHERE RegEmail = '".$_POST['email']."'";
					if ($result = $mysqli->query($sql)) {
						if ($result->num_rows == 0) {
						  	$regCode = $_SESSION['s_id'];

							$sql = "SELECT * FROM Table109 WHERE RegCode = ".$regCode." AND FamilyCode = 1001 LIMIT 1;";

							if ($result = $mysqli->query($sql)) {
								$parenMember = $result->fetch_assoc();
								
								if ($result->num_rows == 1) {
									
									
									$sql = "SELECT MAX(FamilyCode) as 'FamilyCode' FROM Table107 WHERE RegCode = ".$regCode;

									if ($result = $mysqli->query($sql)) {
										if ($result->num_rows == 0) {
										  $familyCode = 1001;
										}
									    else{
									      while ($row = $result->fetch_assoc()) {
									        if (is_null($row['FamilyCode'])) {
									          $familyCode = 1001;     
									        }
									        else{
									          $familyCode = intval($row['FamilyCode']) + 1;
									        }
									      }
									    }
									}
								
										
									$sql = "";
									//$sql = "DELETE FROM Table107 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode;
									//$sql .= "DELETE FROM Table109 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode;

									if ($_POST['access'] == 1 && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {

										$sql .= build_insert_str('Table109',array(
											$regCode,
											$_POST['name'],
											$_POST['email'],
											hash("sha256", $_POST['password']),
											$_POST['mobile'],
											$familyCode,
											(($familyCode == 1001) ? 1 : 2), // => 1 for parent and 2 for child
											1 	// => 1 for active and 2 for inactive
										));

									}
									else{
										if ($_POST['access'] == 2) {

											$sql .= build_insert_str('Table107',array(
												$regCode,
												$familyCode,
												$_POST['name'],
												$_POST['relation'],
												"'".$_POST['dob']."'",
												$_POST['email'],
												$_POST['mobile'],
												"",
												intval($_POST['gender']),
												0,
												1
											));
											
										}
										else{
											$response['status'] = 0;
											$response['message'] = "Please enter password and confirm password";
										}
									}
									
									$sql .= "UPDATE `Table122` SET `RegFamilySize`= (SELECT count(RegCode) FROM Table107 WHERE RegCode = ".$regCode.") WHERE `RegCode` = ".$regCode.";";
									//echo $sql;
									if ($mysqli->multi_query($sql) === TRUE) {
										$response["status"] = 1;
										$response["message"] = "Successfull";
									}
									else{
										$response["status"] = 0;
										$response["message"] = "Error occured while uploading to the database: ".$mysqli->error;
									}
								}
								else{
									$response['status'] = 0;
									$response['message'] = "No access rights";
								}
							}
							else{
								$response['status'] = 0;
								$response['message'] = "Error occured while uploading to the database: ".$mysqli->error;
							}
						}
						else{

						}
					}
					else{

					}

					$mysqli->close();
				}
				else{
					$response['status'] = 0;
					$response['message'] = "Invalid date";
				}
			}
			else{
				$response['status'] = 0;
				$response['message'] = "Invalid email";
			}
		}
		else{
			$response['status'] = 0;
			$response['message'] = "Invalid Name";
		}
	}
	else{
		$response['status'] = 0;
		$response['message'] = "Required fields are empty";
	}
}
else{
	$response['status'] = 0;
	$response['message'] = "Invalid";
}
//print_r($_POST);
echo json_encode($response);
?>