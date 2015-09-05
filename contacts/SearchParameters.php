<?php

/**
 * User: kbokdia
 * Date: 05/09/15
 * Time: 10:51 AM
 */
class SearchParameters
{
    var $group;
    var $homeArea;
    var $homeCity;
    var $homePhone;
    var $workArea;
    var $workCity;
    var $workPhone;
    var $otherArea;
    var $otherCity;
    var $otherPhone;

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
}