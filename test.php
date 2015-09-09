<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 09/09/15
 * Time: 7:02 PM
 */

function getPasswordList($orderBy){
    global $response,$mysqli,$regCode,$familyCode;

    $sql = "SELECT Table152.RegCode, Table152.PasswordCode, Table152.PasswordTypeCode, Table130.PasswordTypeName, Table152.HolderCode, Table107.FamilyName as 'HolderName',Table152.PasswordName, Table152.LoginID, Table152.LoginPassword1, Table152.LoginPassword2, Table152.InsertedBy, Table152.PrivateFlag, Table152.ActiveFlag FROM Table152
		INNER JOIN Table130 ON Table130.PasswordTypeCode = Table152.PasswordTypeCode
		INNER JOIN Table107 ON Table107.RegCode = Table152.RegCode AND Table107.FamilyCode = Table152.HolderCode
		WHERE Table152.RegCode = ".$regCode." AND ((Table152.InsertedBy != ".$familyCode." and PrivateFlag = 2) or Table152.InsertedBy = ".$familyCode.")
		ORDER BY ".$orderBy.";";
    //echo $sql;
    if ($result = $mysqli->query($sql)) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $response[$i] = $row;
            $i++;
        }
    }
}

do{
    if (isset($_GET['list'])) {
        $listType = intval($_GET['list']);
        getPasswordList("Table107.FamilyName");
    }

    if(!empty($_GET['passwordCode'])){
        $passwordCode = $_GET['passwordCode'];
        $sql = "SELECT Table152.RegCode, Table152.PasswordCode, Table152.PasswordTypeCode, Table130.PasswordTypeName, Table152.HolderCode, Table107.FamilyName as 'HolderName',Table152.PasswordName, Table152.LoginID, Table152.LoginPassword1, Table152.LoginPassword2, Table152.InsertedBy, Table152.PrivateFlag, Table152.ActiveFlag FROM Table152 INNER JOIN Table130 ON Table130.PasswordTypeCode = Table152.PasswordTypeCode LEFT JOIN Table107 ON Table107.RegCode = Table152.RegCode AND Table107.FamilyCode = Table152.HolderCode WHERE Table152.RegCode = ".$regCode." AND Table152.PasswordCode = ".$passwordCode."  ORDER BY FamilyName  LIMIT 1;";
        if($result = $mysqli->query($sql)){
            $response = $result->fetch_assoc();
        }
    }
}while(0);