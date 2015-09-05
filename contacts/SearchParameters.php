<?php

/**
 * User: kbokdia
 * Date: 05/09/15
 * Time: 10:51 AM
 */
class SearchParameters
{
    function getNameClause($value){
        return " LOWER(FullName) LIKE LOWER('%".$value."%') " ;
    }

    function getMobileClause($value){
        return " Mobile1 LIKE '%".$value."%' OR Mobile2 LIKE '%".$value."%' OR Mobile3 LIKE '%".$value."%' ";
    }

    function getEmailClause($value){
        return " Email1 LIKE '%".$value."%' OR Email2 LIKE '%".$value."%' ";
    }

    function getCompanyClause($value){
        return " LOWER(Company) LIKE LOWER('%".$value."%') ";
    }

    function getDesignationClause($value){
        return " LOWER(Designation) LIKE LOWER('%".$value."%') ";
    }

    function getGuardianNameClause($value){
        return " LOWER(GuardianName) LIKE LOWER('%".$value."%') ";
    }

    function getDobClause($value){
        return " Dob LIKE '%".$value."%' ";
    }

    function getDomClause($value){
        return " Dom LIKE '%".$value."%' ";
    }

    function getGroupClause($regCode,$value){
        return " GroupCode in (SELECT GroupCode FROM Table126 WHERE RegCode in ( 10000,".$regCode.") AND LOWER(GroupName) LIKE LOWER('%".$value."%')) ";
    }

    function getHomeAreaClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table153 WHERE RegCode = ".$regCode." AND AreaCode in ( SELECT AreaCode FROM Table119 WHERE RegCode IN (10000,".$regCode.") AND LOWER(AreaName) LIKE LOWER('%".$value."%'))) ";
    }

    function getHomeCityClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table153 WHERE RegCode = ".$regCode." AND CityCode in ( SELECT CityCode FROM Table110 WHERE RegCode IN (10000,".$regCode.") AND LOWER(CityName) LIKE LOWER('%".$value."%'))) ";
    }

    function getHomePhoneClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table153 WHERE RegCode = ".$regCode." AND (Phone1 LIKE '%".$value."%' OR Phone2 LIKE '%".$value."%' OR Phone3 LIKE '%".$value."%') ) ";
    }

    function getWorkAreaClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table155 WHERE RegCode = ".$regCode." AND AreaCode in ( SELECT AreaCode FROM Table119 WHERE RegCode IN (10000,".$regCode.") AND LOWER(AreaName) LIKE LOWER('%".$value."%'))) ";
    }

    function getWorkCityClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table155 WHERE RegCode = ".$regCode." AND CityCode in ( SELECT CityCode FROM Table110 WHERE RegCode IN (10000,".$regCode.") AND LOWER(CityName) LIKE LOWER('%".$value."%'))) ";
    }

    function getWorkPhoneClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table155 WHERE RegCode = ".$regCode." AND (Phone1 LIKE '%".$value."%' OR Phone2 LIKE '%".$value."%' OR Phone3 LIKE '%".$value."%') ) ";
    }

    function getOtherAreaClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table157 WHERE RegCode = ".$regCode." AND AreaCode in ( SELECT AreaCode FROM Table119 WHERE RegCode IN (10000,".$regCode.") AND LOWER(AreaName) LIKE LOWER('%".$value."%'))) ";
    }

    function getOtherCityClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table157 WHERE RegCode = ".$regCode." AND CityCode in ( SELECT CityCode FROM Table110 WHERE RegCode IN (10000,".$regCode.") AND LOWER(CityName) LIKE LOWER('%".$value."%'))) ";
    }

    function getOtherPhoneClause($regCode,$value){
        return " ContactCode in (SELECT ContactCode FROM Table157 WHERE RegCode = ".$regCode." AND (Phone1 LIKE '%".$value."%' OR Phone2 LIKE '%".$value."%' OR Phone3 LIKE '%".$value."%') ) ";
    }
}