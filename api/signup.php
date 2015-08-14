<?php
define("ROOT", "../");

$response = array();

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['c_password']) && !empty($_POST['name']) && !empty($_POST['mobile']) && !empty($_POST['dob'])) {
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		if ($_POST['password'] == $_POST['c_password']) {
			if (strlen($_POST['password']) > 7 && strlen($_POST['password']) < 17) {
				if (preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) {
					if (strlen($_POST['mobile']) == 10) {
						require_once ROOT.'db/Connection.php';
					 	require_once ROOT.'modules/functions.php';
						
						$mysqli = getConnection(); 
						$_POST = safeStringForSQL($_POST);
						
						$sql = "SELECT RegEmail FROM Table109 WHERE RegEmail = '".$_POST['email']."'";
						//echo $sql;
						if ($result = $mysqli->query($sql)) {
							if ($result->num_rows == 0) {
							 	$id = 0;
								$familyCode = 0;

								$sql = "SELECT MAX(RegCode) as 'RegCode' FROM Table109";

								if ($result = $mysqli->query($sql)) {
									if ($result->num_rows == 0) {
									  $id = 10001;
									}
								    else{
								      while ($row = $result->fetch_assoc()) {
								        if (is_null($row['RegCode'])) {
								          $id = 10001;     
								        }
								        else{
								          $id = intval($row['RegCode']) + 1;
								        }
								      }
								    }
								}

								$sql = "SELECT MAX(FamilyCode) as 'FamilyCode' FROM Table107";

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
								$dob = explode("/", $_POST['dob']);
								$dob = array($dob[2],$dob[1],$dob[0]);
								$_POST['dob'] = implode("-", $dob);

								$sql = "";
								$sql .= build_insert_str('Table107',array(
									$id,
									$familyCode,
									$_POST['name'],
									1,
									(empty($_POST['dob']) ? "" : "'".$_POST['dob']."'"),
									$_POST['email'],
									$_POST['mobile'],
									hash("sha256", $_POST['password']),
									1,
									1
								));

								$nextYear = new DateTime("now");
								$nextYear->add(new DateInterval('P1Y'));
								$today = new DateTime("now");

								$sql .= build_insert_str('Table109',array(
									$id,
									$_POST['name'],
									$_POST['email'],
									hash("sha256", $_POST['password']),
									$_POST['mobile'],
									$today->format("Y-m-d"),
									$_POST["country"],
									1, 	// => Renewal Number
									"'".$today->format("Y-m-d")."'",
									"'".$nextYear->format("Y-m-d")."'",
									1,	// => Family Size
									0, 	// => Fees collected
									0, 	// => Data used
									0, 	// => Photo uploaded
									0, 	// => No of hits
									"'".$today->format("Y-m-d H:i:s")."'",
									10000,	// => Contact Serial
									10000, 	// => Invest
									10000, 	// => Assets
									10000, 	// => Document
									10000, 	// => Expense
									10000, 	// => Income
									10000, 	// => Password
									10000, 	// => Extra1
									10000, 	// => Extra2
									10000, 	// => Extra3
									10000, 	// => Extra4
									10000, 	// => Extra5
									10000, 	// => Extra6
									10000, 	// => Extra7
									10000, 	// => Extra8
									10000, 	// => Extra9
									$familyCode,
									1, // => 1 for parent and 2 for child
									1, 	// => 1 for active and 2 for inactive
								));

								//echo $sql;
								if ($mysqli->multi_query($sql) === TRUE) {
									$response["status"] = 1;
									$response["message"] = "You have signed up successfully";
								}
								else{
									$response["status"] = 0;
									$response["message"] = "Error occured while uploading to the database: ".$mysqli->error;
								}

								$mysqli->close();
							}
							else{
								$response['status'] = 0;
								$response['message'] = "This Mail ID is already registered.";
							}
						}
						else{
							$response['status'] = 0;
							$response['message'] = "Error occured while uploading to the database: ".$mysqli->error;
						}
					}
					else{
						$response['status'] = 0;
						$response['message'] = "Enter valid mobile number";
					}
				}
				else{
					$response['status'] = 0;
					$response['message'] = "Enter valid name";
				}
			}
			else{
				$response['status'] = 0;
				$response['message'] = "Password length should be between 8 to 16";
			}
		}
		else{
			$response['status'] = 0;
			$response['message'] = "Entered password and confirm password are not equal";
		}
	}
	else{
		$response['status'] = 0;
		$response['message'] = "Enter valid email id";
	}
}
else{
	$response['status'] = 0;
	$response['message'] = "Required fields are empty";
}

//header('Content-Type: application/json');

echo json_encode($response);
?>