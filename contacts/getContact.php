<?php
define("ROOT", "../");

require_once ROOT.'db/Connection.php';
$mysqli = getConnection();

$contact = array();

if (isset($_GET['id'])) {
	$id  = $_GET['id'];

	if ($id == 0) {
		$sql = "SELECT `registerLicenceCode`, `contactCode`, title.description as 'title', `firstName`, `middleName`, `lastName`, `fullName`, `guardianName`, `company`, `designation`, `alias`, `dob`, `dom`, ".DB_NAME.".group.description as 'group', `emergencyCode`, `remarks`, `activeStatus`, `mobile`, `email`, `facebook`, `twitter`, `google`, `linkedin`, `website`, `noOfAddresses`, `noOfFamilyMembers`, `photoUploaded`, `userCode`, `privacy`, `lastAccessedDate` 
				FROM contact
				LEFT JOIN title ON title.code = contact.titleCode
				LEFT JOIN ".DB_NAME.".group ON ".DB_NAME.".group.code = contact.groupCode
				ORDER BY contact.fullName LIMIT 1";
		if ($result = $mysqli->query($sql)) {
			$contact = $result->fetch_assoc();
		}
	}
	else{
		$sql = "SELECT `registerLicenceCode`, `contactCode`, title.description as 'title', `firstName`, `middleName`, `lastName`, `fullName`, `guardianName`, `company`, `designation`, `alias`, `dob`, `dom`, ".DB_NAME.".group.description as 'group', `emergencyCode`, `remarks`, `activeStatus`, `mobile`, `email`, `facebook`, `twitter`, `google`, `linkedin`, `website`, `noOfAddresses`, `noOfFamilyMembers`, `photoUploaded`, `userCode`, `privacy`, `lastAccessedDate` 
				FROM contact
				LEFT JOIN title ON title.code = contact.titleCode
				LEFT JOIN ".DB_NAME.".group ON ".DB_NAME.".group.code = contact.groupCode
				WHERE contact.contactCode =".$id;
		if ($result = $mysqli->query($sql)) {
			$contact = $result->fetch_assoc();
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
?>