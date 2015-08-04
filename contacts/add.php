<?php
$url = "http://incorelabs.com";
header("Access-Control-Allow-Origin:".$url);
header("Access-Control-Request-Method: GET, POST");
header("Access-Control-Allow-Credentials: true");

define("ROOT", "../");

require_once ROOT.'db/Connection.php';
require_once ROOT.'modules/functions.php';

function getCode($pCodeKey,$pKey,$tableName,$tableValues,$timestamp=1001){
	$code = 0;
	$sql = "";
	if (isset($_POST[$pCodeKey])) {
		if (intval($_POST[$pCodeKey]) >= 0) {
			$code = $_POST[$pCodeKey];
		}
		elseif (isset($_POST[$pKey]) && strlen($_POST[$pKey]) > 0) {
			$sql .= build_insert_str($tableName,$tableValues);
			$code =  $tableValues[0];
		}
	}
	return array("code"=>$code,"sql"=>$sql);
}

function hasDataWithPostKey($pkeys){
	$hasData = true;
	
	foreach ($pkeys as $key => $value) {
		if (isset($_POST[$value])) {
			if (is_null($_POST[$value]) || $_POST[$value] == "") {
				$hasData = false;
			}
			else{
				$hasData = true;
				break;
			}
		}
	}

	return $hasData;
		
}

$mysqli = getConnection();

$id = 0; 
$addressSerial = 0;
$status = 0;
$response = array();

if (isset($_POST['id'])) {

	if (isset($_POST["inputType"])) {
		if (intval($_POST["inputType"]) == 1) {
			
			$sql = "SELECT MAX(contactCode) as 'contactCode' FROM contact";

			if ($result = $mysqli->query($sql)) {
				if ($result->num_rows == 0) {
				  $id = 1001;
				}
			    else{
			      while ($row = $result->fetch_assoc()) {
			        if (is_null($row['contactCode'])) {
			          $id = 1001;     
			        }
			        else{
			          $id = intval($row['contactCode']) + 1;
			        }
			      }
			    }
			}
		}
		elseif (intval($_POST["inputType"]) == 2) {
			$id = $_POST["id"];
		}
	}

	$sql = "SELECT serialNo FROM address WHERE contactCode = ".$id;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows == 0) {
		  $addressSerial = 1001;
		}
		else{
			while ($row = $result->fetch_assoc()) {
				$addressSerial = intval($row['serialNo']) + 1;
			}	
		}
	}

	$date = new DateTime();
	$timestamp = $date->getTimestamp();
	$titleCode = 0;
	$groupCode = 0;
	$countryCode = array();
	$stateCode = array();
	$cityCode = array();
	$areaCode = array();
	$sql = "";

	//Title ID manipulations
	if (isset($_POST['titleId'])) {
		if (intval($_POST['titleId']) >= 0) {
			$titleCode = $_POST['titleId'];
		}
		elseif (isset($_POST['title']) && strlen($_POST['title']) > 0) {
			$sql = build_insert_str('title',array(
				$timestamp,
				$_POST['title'],
				'1001'
				));
			$titleCode = $timestamp;
		}
	}
		
	
	//Group ID manipulation
	if (isset($_POST["groupId"])) {
		if (intval($_POST['groupId']) >= 0) {
			$groupCode = $_POST['groupId'];
		}
		elseif (isset($_POST['group']) && strlen($_POST['group']) > 0) {
			$sql .= build_insert_str(DB_NAME.'.group',array(
			$timestamp,
			$_POST['group'],
			'1001'
			));

			$groupCode =  $timestamp;
		}
	}

	//Home Country Code Manipulation
	if (isset($_POST["homeCountryCode"])) {
		$values = array($timestamp, $_POST['homeCountry'],'1001');

		$result = getCode("homeCountryCode","homeCountry","country",$values);
		$countryCode['home'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}
	//work Country Code Manipulation
	if (isset($_POST["workCountryCode"])) {
		$values = array($timestamp+1, $_POST['workCountry'],'1001');

		$result = getCode("workCountryCode","workCountry","country",$values);
		$countryCode['work'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}
	//other Country Code Manipulation
	if (isset($_POST["otherCountryCode"])) {
		$values = array($timestamp+2, $_POST['otherCountry'],'1001');

		$result = getCode("otherCountryCode","otherCountry","country",$values);
		$countryCode['other'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}

	//Home State Code Manipulation
	if (isset($_POST["homeStateCode"])) {
		$values = array($timestamp, $_POST['homeState'],$countryCode["home"],'1001');

		$result = getCode("homeStateCode","homeState","state",$values);
		$stateCode['home'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}
	//work State Code Manipulation
	if (isset($_POST["workStateCode"])) {
		$values = array($timestamp+1, $_POST['workState'],$countryCode["work"],'1001');

		$result = getCode("workStateCode","workState","state",$values);
		$stateCode['work'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}
	//other State Code Manipulation
	if (isset($_POST["otherStateCode"])) {
		$values = array($timestamp+2, $_POST['otherState'],$countryCode["other"],'1001');

		$result = getCode("otherStateCode","otherState","state",$values);
		$stateCode['other'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}

	//Home City Code Manipulation
	if (isset($_POST["homeCityCode"])) {
		$values = array($timestamp, $_POST['homeCity'],$countryCode["home"],$stateCode["home"],'1001');

		$result = getCode("homeCityCode","homeCity","city",$values);
		$cityCode['home'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}
	//work City Code Manipulation
	if (isset($_POST["workCityCode"])) {
		$values = array($timestamp+1, $_POST['workCity'],$countryCode["work"],$stateCode["work"],'1001');

		$result = getCode("workCityCode","workCity","city",$values);
		$cityCode['work'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}
	//other City Code Manipulation
	if (isset($_POST["otherCityCode"])) {
		$values = array($timestamp+2, $_POST['otherCity'],$countryCode["other"],$stateCode["other"],'1001');

		$result = getCode("otherCityCode","otherCity","city",$values);
		$cityCode['other'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}

	//Home Area Code Manipulation
	if (isset($_POST["homeAreaCode"])) {
		$values = array($timestamp, $_POST['homeArea'],$countryCode["home"],$stateCode["home"],$cityCode["home"],'1001');

		$result = getCode("homeAreaCode","homeArea","area",$values);
		$areaCode['home'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}
	//work Area Code Manipulation
	if (isset($_POST["workAreaCode"])) {
		$values = array($timestamp+1, $_POST['workArea'],$countryCode["work"],$stateCode["work"],$cityCode["work"],'1001');

		$result = getCode("workAreaCode","workArea","area",$values);
		$areaCode['work'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}
	//other Area Code Manipulation
	if (isset($_POST["otherAreaCode"])) {
		$values = array($timestamp+2, $_POST['otherArea'],$countryCode["other"],$stateCode["other"],$cityCode["other"],'1001');

		$result = getCode("otherAreaCode","otherArea","area",$values);
		$areaCode['other'] = ($result['code'] > 0) ? intval($result['code']) : 0;
		
		if ($result['sql'] != "") {
			$sql .= $result['sql'];
		}
	}

	
	//Address Type
	/*if ($addressSerial == 1001) {
		$sql .= build_insert_str('addressType', array(
			$timestamp,
			"Home",
			'1001'
			));

		$sql .= build_insert_str('addressType', array(
			$timestamp+1,
			"Work",
			'1001'
			));

		$sql .= build_insert_str('addressType', array(
			$timestamp+2,
			"Other",
			'1001'
			));
	}*/

	$sql .= buildDeleteStr("contact",array('contactCode'=>intval($id)));
	$sql .= buildDeleteStr("address",array('contactCode'=>intval($id)));

	//Address
	if (hasDataWithPostKey(array("homeAddress1","homePincode","homeArea","homeCity","homeState","homeCountry","homePhone"))) {
		$sql .= build_insert_str('address',array(
		1001,
		$id,
		$addressSerial,
		1001,
		(isset($_POST['homeAddress1']) ? $_POST['homeAddress1'] : "")."\n".(isset($_POST['homeAddress2']) ? $_POST['homeAddress2'] : "")."\n".(isset($_POST['homeAddress3']) ? $_POST['homeAddress3'] : "")."\n".(isset($_POST['homeAddress4']) ? $_POST['homeAddress4'] : "")."\n".(isset($_POST['homeAddress5']) ? $_POST['homeAddress5'] : ""),
		(isset($_POST['homeAddress1']) ? $_POST['homeAddress1'] : ""),
		(isset($_POST['homeAddress2']) ? $_POST['homeAddress2'] : ""),
		(isset($_POST['homeAddress3']) ? $_POST['homeAddress3'] : ""),
		(isset($_POST['homeAddress4']) ? $_POST['homeAddress4'] : ""),
		(isset($_POST['homeAddress5']) ? $_POST['homeAddress5'] : ""),
		(isset($_POST['homePincode']) ? $_POST['homePincode'] : ""),
		$countryCode["home"],
		$stateCode["home"],
		$cityCode["home"],
		$areaCode["home"],
		(isset($_POST['homePhone']) ? $_POST['homePhone'] : ""),
			));
	}
	
	//Work Address
	if (hasDataWithPostKey(array("workAddress1","workPincode","workArea","workCity","workState","workCountry","workPhone"))) {
		$sql .= build_insert_str('address',array(
		1001,
		$id,
		$addressSerial+1,
		1002,
		(isset($_POST['workAddress1']) ? $_POST['workAddress1'] : "")."\n".(isset($_POST['workAddress2']) ? $_POST['workAddress2'] : "")."\n".(isset($_POST['workAddress3']) ? $_POST['workAddress3'] : "")."\n".(isset($_POST['workAddress4']) ? $_POST['workAddress4'] : "")."\n".(isset($_POST['workAddress5']) ? $_POST['workAddress5'] : ""),
		(isset($_POST['workAddress1']) ? $_POST['workAddress1'] : ""),
		(isset($_POST['workAddress2']) ? $_POST['workAddress2'] : ""),
		(isset($_POST['workAddress3']) ? $_POST['workAddress3'] : ""),
		(isset($_POST['workAddress4']) ? $_POST['workAddress4'] : ""),
		(isset($_POST['workAddress5']) ? $_POST['workAddress5'] : ""),
		(isset($_POST['workPincode']) ? $_POST['workPincode'] : ""),
		$countryCode["work"],
		$stateCode["work"],
		$cityCode["work"],
		$areaCode["work"],
		(isset($_POST['workPhone']) ? $_POST['workPhone'] : ""),
			));
	}
	
	//other Address
	if (hasDataWithPostKey(array("otherAddress1","otherPincode","otherArea","otherCity","otherState","otherCountry","otherPhone"))) {
		$sql .= build_insert_str('address',array(
		1001,
		$id,
		$addressSerial+2,
		1003,
		(isset($_POST['otherAddress1']) ? $_POST['otherAddress1'] : "")."\n".(isset($_POST['otherAddress2']) ? $_POST['otherAddress2'] : "")."\n".(isset($_POST['otherAddress3']) ? $_POST['otherAddress3'] : "")."\n".(isset($_POST['otherAddress4']) ? $_POST['otherAddress4'] : "")."\n".(isset($_POST['otherAddress5']) ? $_POST['otherAddress5'] : ""),
		(isset($_POST['otherAddress1']) ? $_POST['otherAddress1'] : ""),
		(isset($_POST['otherAddress2']) ? $_POST['otherAddress2'] : ""),
		(isset($_POST['otherAddress3']) ? $_POST['otherAddress3'] : ""),
		(isset($_POST['otherAddress4']) ? $_POST['otherAddress4'] : ""),
		(isset($_POST['otherAddress5']) ? $_POST['otherAddress5'] : ""),
		(isset($_POST['otherPincode']) ? $_POST['otherPincode'] : ""),
		$countryCode["other"],
		$stateCode["other"],
		$cityCode["other"],
		$areaCode["other"],
		(isset($_POST['otherPhone']) ? $_POST['otherPhone'] : ""),
			));
	}

	if (hasDataWithPostKey(array("firstName"))) {
		$sql .= build_insert_str('contact',array(
		1001,
		$id,
		$_POST['firstName'],
		$_POST['middleName'],
		$_POST['lastName'],
		$_POST['firstName']." ".$_POST['middleName']." ".$_POST['lastName'],
		$titleCode,
		$_POST['guardianName'],
		$_POST['company'],
		$_POST['designation'],
		$_POST['alias'],
		$_POST['dob'],
		$_POST['dom'],
		$groupCode,
		null,
		$_POST['remarks'],
		(isset($_POST['activeStatus']) ? 1 : 0),
		$_POST['mobile'],
		$_POST['email'],
		$_POST['facebook'],
		$_POST['twitter'],
		$_POST['google'],
		$_POST['linkedin'],
		$_POST['website'],
		3,
		null,
		null,
		1001,
		(isset($_POST['privacy']) ? 1 : 0),
		$timestamp
		));

		$status = 1;

		//echo $sql;
		if ($mysqli->multi_query($sql) === TRUE) {
			$response["status"] = $status;
			$response["controller"] = "add";
			$response["landing"] = $id;
			$response["message"] = "Successfully added to your contacts";
		}
		else{
			$response["status"] = 0;
			$response["controller"] = "add";
			$response["landing"] = $id;
			$response["message"] = "Error occured while uploading to the database: ".$mysqli->error;
		}
	}
	else{
		$response["status"] = 0;
		$response["controller"] = "add";
		$response["landing"] = $id;
		$response["message"] = "Basic details where missing";
	}
	
	echo json_encode($response);

}
?>