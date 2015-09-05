<?php
define("ROOT", "");
require_once ROOT.'db/Connection.php';
$mysqli = getConnection();
$fields = array();
$tableName = "Table119";

function getCSString($fields){
    $str = "";
    foreach($fields as $value){
        $str .= "s".$value["name"]." ".$value["type"].",<br>";
    }
    return $str;
}

$sql = "SHOW COLUMNS FROM .$tableName";
if ($result = $mysqli->query($sql)) {
    $i = 0;
    while($row = $result->fetch_assoc()){
        $fields[$i]["name"] = $row["Field"];
        $fields[$i]["type"] = $row["Type"];
        $i++;
    }
}

$str = "CREATE PROCEDURE sp".$tableName."(\n";
$str .= getCSString($fields);

//Insert
$str .= "sModeFlag tinyint(1)<br>)<br>
        BEGIN<br>
            if sModeFlag = 1 then<br>
                INSERT INTO ".$tableName."
		        VALUES(<br>";
foreach($fields as $value){
    $str .= "s".$value["name"].",<br>";
}
//$str .= getCSString($fields);
$str = rtrim($str,",<br>");

//Update
$str .= "<br>);<br><br>
         elseif sModeFlag = 2 then<br>
            UPDATE ".$tableName."<br>
            SET<br>";
foreach($fields as $value){
    $str .= $value["name"]." = s".$value["name"].",<br>";
}
$str = rtrim($str,",<br>");
$str .= "<br>WHERE ".$fields[0]["name"]." = s".$fields[0]["name"].";<br><br>";

//Delete
$str .= "elseif sModeFlag = 3 then<br>";
$str .= "DELETE FROM ".$tableName." WHERE ".$fields[0]["name"]." = s".$fields[0]["name"].";<br><br>";
$str .= "end if;<br>END";
echo $str;
//print_r($fields);
?>