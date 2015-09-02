<?php
$url = "http://incorelabs.com";
header("Access-Control-Allow-Origin:".$url);
header("Access-Control-Request-Method: GET, POST");
header("Access-Control-Allow-Credentials: true");
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
$mysqli = getConnection();

$contact = array();
$addressType = array("home","work","other");

if (isset($_GET['id'])) {
	$id  = $_GET['id'];

	if ($id == 0) {
		$sql = "SELECT contact.`registerLicenceCode`, contact.`contactCode`, title.description as 'contactTitle', contact.`titleCode`, `firstName`, `middleName`, `lastName`, `fullName`, `guardianName`, `company`, `designation`, `alias`, `dob`, `dom`, ".DB_NAME.".group.description as 'group', contact.`groupCode`,`emergencyCode`, `remarks`, `activeStatus`, `mobile`, `email`, `facebook`, `twitter`, `google`, `linkedin`, `website`, `noOfAddresses`, `noOfFamilyMembers`, `photoUploaded`, images.path as 'imageLocation', `userCode`, `privacy`, `lastAccessedDate` 
				FROM contact
				LEFT JOIN title ON title.code = contact.titleCode
				LEFT JOIN ".DB_NAME.".group ON ".DB_NAME.".group.code = contact.groupCode
				LEFT JOIN images ON images.contactCode = contact.contactCode AND images.serialNo = 1
				ORDER BY contact.fullName LIMIT 1";
		if ($result = $mysqli->query($sql)) {
			$contact["contact"] = $result->fetch_assoc();
		}

		$id = $contact["contact"]["contactCode"];

		$sql = "SELECT address.`registeredLicenceCode`, `contactCode`, `serialNo`, `typeCode`, `address`, `address1`, `address2`, `address3`, `address4`, `address5`, `pincode`, country.description as 'country', address.`countryCode`, address.`stateCode`, address.`cityCode`, address.`areaCode`, state.description as 'state', city.description as 'city', area.description as 'area', `phone` 
				FROM `address` 
				LEFT JOIN country ON country.code = address.countryCode
				LEFT JOIN state ON state.code = address.stateCode
				LEFT JOIN city ON city.code = address.cityCode
				LEFT JOIN area ON area.code = address.areaCode
				WHERE contactCode = ".$id."
				ORDER BY address.typeCode";

		if ($result = $mysqli->query($sql)) {
			$i=0;
			while ($row = $result->fetch_assoc()) {
				$contact["address"][$addressType[$i]] = $row;
				$i++;
			}
		}

	}
	else{
		$sql = "SELECT contact.`registerLicenceCode`, contact.`contactCode`, title.description as 'contactTitle', contact.`titleCode`, `firstName`, `middleName`, `lastName`, `fullName`, `guardianName`, `company`, `designation`, `alias`, `dob`, `dom`, ".DB_NAME.".group.description as 'group', contact.`groupCode`,`emergencyCode`, `remarks`, `activeStatus`, `mobile`, `email`, `facebook`, `twitter`, `google`, `linkedin`, `website`, `noOfAddresses`, `noOfFamilyMembers`, `photoUploaded`, images.path as 'imageLocation', `userCode`, `privacy`, `lastAccessedDate` 
				FROM contact
				LEFT JOIN title ON title.code = contact.titleCode
				LEFT JOIN ".DB_NAME.".group ON ".DB_NAME.".group.code = contact.groupCode
				LEFT JOIN images ON images.contactCode = contact.contactCode AND images.serialNo = 1
				WHERE contact.contactCode =".$id;
		if ($result = $mysqli->query($sql)) {
			$contact["contact"] = $result->fetch_assoc();
		}

		$sql = "SELECT address.`registeredLicenceCode`, `contactCode`, `serialNo`, `typeCode`, `address`, `address1`, `address2`, `address3`, `address4`, `address5`, `pincode`, country.description as 'country', address.`countryCode`, address.`stateCode`, address.`cityCode`, address.`areaCode`, state.description as 'state', city.description as 'city', area.description as 'area', `phone` 
				FROM `address` 
				LEFT JOIN country ON country.code = address.countryCode
				LEFT JOIN state ON state.code = address.stateCode
				LEFT JOIN city ON city.code = address.cityCode
				LEFT JOIN area ON area.code = address.areaCode
				WHERE contactCode = ".$id."
				ORDER BY address.typeCode";

		if ($result = $mysqli->query($sql)) {
			$i=0;
			while ($row = $result->fetch_assoc()) {
				$contact["address"][$addressType[$i]] = $row;
				$i++;
			}
		}
	}
}

if (isset($_GET['list'])) {
	$sql = "SELECT contactCode,fullName FROM contact ORDER BY fullName;";
	if ($result = $mysqli->query($sql)) {
		$i = 0;
		while ($row = $result->fetch_assoc()) {
			$contact[$i] = array($row['contactCode'],$row['fullName']);
			$i++;
		}
	}
}

echo json_encode($contact);
$mysqli->close();
?>