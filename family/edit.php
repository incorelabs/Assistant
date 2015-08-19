<?php
session_start();
define("ROOT", "../");

include_once ROOT.'dist/authenticate.php';


$familyCode = 0;
$response = array();

if (isset($_POST)) {
	if (!empty($_POST["name"]) && !empty($_POST["relation"]) && !empty($_POST['dob']) && !empty($_POST['email']) && !empty($_POST['gender']) && !empty($_POST['familyCode'])) {
		if (preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) {
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$dob = explode("/", $_POST['dob']);
				$dob = array($dob[2],$dob[1],$dob[0]);
				if (strlen($dob[0]) == 4 && $dob[1] < 13 && $dob[2] < 32) {
					$_POST['dob'] = implode("-", $dob);

					require_once ROOT.'db/Connection.php';
					require_once ROOT.'modules/functions.php';
					$mysqli = getConnection();
					$_POST = safeStringForSQL($_POST);
					$_POST['access'] = intval($_POST['access']);
					$isMailIDRegistered = true;
					$performQuery = true;

					$regCode = intval($_SESSION['s_id']);
					$familyCode = intval($_POST['familyCode']);

					$qry = "SELECT RegEmail FROM Table109 WHERE RegEmail = '".$_POST['email']."'";
					//echo $qry;
					if ($result = $mysqli->query($qry)) {
						if ($result->num_rows == 0) {
							$isMailIDRegistered = false;
						}
					}

					$sql = "SELECT * FROM Table109 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode." LIMIT 1;";

					if ($result = $mysqli->query($sql)) {
						
						do {
							$sql = "";
							//Present in Table109
							if ($result->num_rows == 1) {
								//If record is present and access rights is given then update
								if ($_POST['access'] == 1){
									/*if ($isMailIDRegistered) {
										$performQuery = false;
										break;
									}*/

									
									$sql .= "UPDATE `Table109` SET `RegName`= '".$_POST['name']."', `RegMobile`= '".$_POST['mobile']."', `ActiveFlag`= 1 WHERE `RegCode` = ".$regCode." AND `FamilyCode`= ".$familyCode.";";

									$sql .= "DELETE FROM Table107 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode.";";
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
										1,
										1
									));
								}
								//If record is present and access rights is removed then delete
								elseif ($_POST['access'] == 2) {
									$sql .= "DELETE FROM Table109 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode.";";

									$sql .= "DELETE FROM Table107 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode.";";
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
							}
							//Not present in Table109
							else{
								if ($_POST['access'] == 1 && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
									if ($isMailIDRegistered) {
										$performQuery = false;
										break;
									}


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

									$sql .= "DELETE FROM Table107 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode.";";
									$sql .= build_insert_str('Table107',array(
										$regCode,
										$familyCode,
										$_POST['name'],
										$_POST['relation'],
										"'".$_POST['dob']."'",
										$_POST['email'],
										$_POST['mobile'],
										hash("sha256", $_POST['password']),
										intval($_POST['gender']),
										1,
										1
									));
								}
								else{
									$sql .= "DELETE FROM Table107 WHERE RegCode = ".$regCode." AND FamilyCode = ".$familyCode.";";
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

								$sql .= "UPDATE `Table122` SET `RegFamilySize`= (SELECT count(RegCode) FROM Table107 WHERE RegCode = ".$regCode.") WHERE `RegCode` = ".$regCode.";";

							}
						} while (0);
						
						if ($performQuery) {
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
							$response["status"] = 0;
							$response["message"] = "Mail ID is already registered";
						}
					
						
					}
					else{
						$response['status'] = 0;
						$response['message'] = "Error occured while uploading to the database: ".$mysqli->error;
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