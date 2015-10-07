<?php
/**
 * Created by PhpStorm.
 * User: kbokdia
 * Date: 05/10/15
 * Time: 5:24 PM
 */

namespace Assistant\Assets;


class AssetDetail
{
    var $assetCode;
    var $detail;
    var $mysqli;
    var $regCode;
    var $response;
    var $successful; // if asset retrieved then successful
    var $errMsg;

    function __construct($assetCode){
        $this->assetCode = $assetCode;
        $this->regCode = intval($_SESSION['s_id']);
        $this->mysqli = getConnection();
        $this->setAssetDetail();
    }

    function getAssetDetailQuery(){
        $sql = "SELECT Table168.RegCode, Table168.AssetCode, Table168.AssetTypeCode, Table127.AssetTypeName, Table168.HolderCode, Table107.FamilyName as 'HolderName', Table168.AssetName, Table168.JointHolder, Table168.BoughtFrom, a1.FullName AS 'BoughtName', Table168.ServiceCentre, a2.FullName AS 'ServiceCentreName', Table168.LocationCode, Table132.LocationName, Table168.SerialNo, Table168.ModelName, Table168.Remarks, Table168.BillNo, DATE_FORMAT(Table168.BillDate,'%d/%m/%Y') AS 'BillDate', DATE_FORMAT(Table168.WarrantyUpto,'%d/%m/%Y') AS 'WarrantyUpto', Table168.PurchaseAmount, Table168.PhotoUploaded, Table168.PhotoCount, Table168.InsertedBy, Table168.PrivateFlag, Table168.ActiveFlag, Table168.LastAccessDate FROM Table168 INNER JOIN Table127 ON Table127.AssetTypeCode = Table168.AssetTypeCode INNER JOIN Table107 ON Table107.FamilyCode = Table168.HolderCode INNER JOIN Table132 ON Table132.LocationCode = Table168.LocationCode LEFT JOIN Table151 a1 ON Table168.RegCode = a1.RegCode AND Table168.BoughtFrom = a1.ContactCode LEFT JOIN Table151 a2 ON Table168.RegCode = a2.RegCode AND Table168.ServiceCentre = a2.ContactCode WHERE Table168.RegCode = ".$this->regCode." AND Table168.AssetCode = ".$this->assetCode." ORDER BY Table107.FamilyName LIMIT 1";
        return $sql;
    }

    function setAssetDetail(){
        $sql = $this->getAssetDetailQuery();
        if($result = $this->mysqli->query($sql)){
            if($result->num_rows == 1){
                $this->successful = true;
                $this->detail["asset"] = $result->fetch_assoc();
            }
            else{
                $this->successful = false;
                $this->errMsg = "No detail";
            }
        }
        else{
            $this->successful = false;
            $this->errMsg = $this->mysqli->error;
        }
    }


    function getResponse(){
        if($this->successful){
            $this->response = $this->createResponse(1,"Success");
            $this->response["detail"] = $this->detail;
        }
        else{
            $this->response = $this->createResponse(0,$this->errMsg);
        }
        return $this->response;
    }

    function createResponse($status,$message){
        return array('status' => $status, 'message' => $message);
    }

    function __destruct(){
        $this->mysqli->close();
    }
}